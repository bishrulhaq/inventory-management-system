<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;

class OrderController extends Controller
{
    public function store(Request $request){

    	$data=new Order;
    	$data->email= $request->email;
        $data->product_code = $request->code;
        $data->product_name = $request->name;
        $data->quantity = $request->quantity;
    	$data->order_status = 0;
        $data->save();
        return Redirect()->route('all.orders');

    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->delete();
            return redirect()->back()->with('success', 'Order deleted successfully');
        }
        return redirect()->back()->with('error', 'Order not found');
    }

    public function newStore(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'name' => 'required',
            'quantity' => 'required|numeric',
            'company' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable'
        ]);

        $productCode = $validatedData['code'];
        $requestedQuantity = $validatedData['quantity'];

        $product = Product::where('product_code', $productCode)->first();

        if ($product) {

            if ($requestedQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Requested quantity exceeds available stock!');
            }

            $data = new Order;
            $data->email = $validatedData['email'];
            $data->product_code = $productCode;
            $data->product_name = $product->name;
            $data->quantity = $requestedQuantity;
            $data->order_status = 0;
            $data->save();

            $customer = Customer::where('email', $request->email)->first();
            if ($customer === null) {
                $customer = new Customer;
                $customer->name = $request->name;
                $customer->email = $request->email;
                $customer->company = $request->company;
                $customer->address = $request->address;
                $customer->phone = $request->phone;
                $customer->save();
            }

            return redirect()->route('all.orders');
        }

        return redirect()->back()->with('error', 'Product not found!');
    }


    public function newformData(){
        $products = Product::all();
        $customers = Customer::get();
        return view('Admin.new_order',compact('products','customers'));
    }

    public function ordersData(){
        $orders = Order::all();
        return view('Admin.all_orders',compact('orders'));
    }

    public function pendingOrders(){
        $orders = Order::where('order_status','=','0')->get();
        return view('Admin.pending_orders',compact('orders'));
    }

    public function deliveredOrders(){
        $orders = Order::where('order_status','!=','0')->get();
        return view('Admin.delivered_orders',compact('orders'));
    }
}
