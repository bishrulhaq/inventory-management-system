<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'customer' => 'required|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'item' => 'required|max:255',
            'name' => 'required|max:255',
            'unit_price' => 'required|numeric',
            'quantity' => 'required|numeric|min:1',
            'total' => 'required|numeric|min:0',
            'payment' => 'required|numeric|min:0',
            'product_code' => 'required',
            'phone' => 'nullable|numeric',
            'order_id' => 'required',
        ]);

        $data = new Invoice;
        $data->customer_name = $validatedData['customer'];
        $data->customer_mail = $validatedData['email'];
        $data->company = $validatedData['company'];
        $data->address = $validatedData['address'];
        $data->item = $validatedData['item'];
        $data->product_name = $validatedData['name'];
        $data->price = $validatedData['unit_price'];
        $data->quantity = $validatedData['quantity'];
        $data->total = $validatedData['total'];
        $data->payment = $validatedData['payment'];
        $data->due = $validatedData['total'] - $validatedData['payment'];
        $data->save();

        Order::where('id', $validatedData['order_id'])->update([
            'email' => $validatedData['email'],
            'quantity' => $validatedData['quantity'],
            'order_status' => 1,
        ]);

        $customer = Customer::where('email', '=', $request->email)->first();

        if ($customer === null) {
            $data3 = new Customer;
            $data3->name = $request->customer;
            $data3->email = $request->email;
            $data3->company = $request->company;
            $data3->address = $request->address;
            $data3->phone = $request->phone;
            $data3->save();
        }

        $products = DB::table('products')->where('category', $request->item)->first();

        $mainqty = $products->stock;
        $nowqty = $mainqty - $request->quantity;

        DB::table('products')->where('name', $request->name)->update(['stock' => $nowqty]);
        Order::where('id', $validatedData['order_id'])->update(['order_status' => '1']);

        return redirect()->route('invoice.details', ['id' => $data->id]);
    }

    public function show($id)
    {
        $data = Invoice::find($id);

        if (! $data) {
            return redirect()->route('dashboard');
        }

        return view('Admin.invoice_details', compact('data'));
    }

    public function formData($id)
    {
        $order = Order::where('id', $id)->first();
        $product = Product::where('product_code', $order->product_code)->first();
        $customer = Customer::where('email', $order->email)->first();

        return view('Admin.add_invoice', compact('order', 'product', 'customer', 'id'));
    }

    public function newformData()
    {
        $products = Product::all();
        $customers = Customer::all();

        return view('Admin.new_invoice', compact('products', 'customers'));
    }

    public function allInvoices()
    {
        $invoices = Invoice::all();

        return view('Admin.all_invoices', compact('invoices'));
    }

    public function soldProducts()
    {
        $products = Invoice::select('product_name', Invoice::raw('SUM(quantity) as count'))
            ->groupBy(Invoice::raw('product_name'))->get();

        // ?print_r($products);
        return view('Admin.sold_products', compact('products'));
    }

    public function delete()
    {
        Invoice::truncate();
    }

    public function payDue($id)
    {
        $data = Invoice::find($id);

        $prev_due = $data->due;

        if ($data && $data->due > 0) {
            $data->due = 0;
            $data->payment = $data->payment + $prev_due;
            $data->save();

            return view('Admin.due_payment_receipt', compact('data', 'prev_due'));
        }

        return redirect()->route('dashboard')->with('error', 'Invoice not found or no due to pay');
    }
}
