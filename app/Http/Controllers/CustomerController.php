<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = new Customer;
        $customer = $customer->get();

        return view('dashbord.dashbord', [
            'customer' => $customer,
        ]);

    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        if (! $customer) {
            return redirect()->back()->with('error', 'Customer not found');
        }

        return view('Admin.edit_customer', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required',
            'company' => 'nullable|max:255',
            'address' => 'nullable|max:255',
            'phone' => 'nullable|max:20',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->name = $validatedData['name'];
        $customer->company = $validatedData['company'];
        $customer->address = $validatedData['address'];
        $customer->phone = $validatedData['phone'];
        $customer->save();

        return redirect()->route('customers.edit', $id)->with('success', 'Customer updated successfully');
    }

    public function create()
    {
        return view('customer.create');

    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'company' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|max:20',
        ]);

        $customer = new Customer;
        $customer->name = $validatedData['name'];
        $customer->email = $validatedData['email'];
        $customer->company = $validatedData['company'];
        $customer->address = $validatedData['address'];
        $customer->phone = $validatedData['phone'];

        $customer->save();

        return redirect()->route('add.customer')->with('message_success', 'Customer added successfully!');
    }

    public function customersData()
    {
        $customers = Customer::all();

        return view('Admin.all_customers', compact('customers'));
    }

    public function delete($id)
    {
        $customer = Customer::find($id);
        if ($customer->delete()) {

            return redirect()->back()->with(['msg' => 1]);
        } else {
            return redirect()->back()->with(['msg' => 2]);
        }

    }
}
