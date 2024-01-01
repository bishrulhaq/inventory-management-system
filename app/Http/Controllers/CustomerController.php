<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = new Customer();
        $customer = $customer->get();
        return view('dashbord.dashbord', [
            'customer' => $customer
        ]);

    }

    public function edit($id)
    {
        $customers = Customer::where('id', '=', $id)->get();

        return view('customer.edit_customer', compact('customers'));

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

        $customer = new Customer();
        $customer->name = $validatedData['name'];
        $customer->email = $validatedData['email'];
        $customer->company = $validatedData['company'];
        $customer->address = $validatedData['address'];
        $customer->phone = $validatedData['phone'];

        $customer->save();
        return redirect()->route('add.customer')->with('message_success', 'Customer added successfully!');
    }

    public function update($id, Request $request)
    {

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->password = $request->password;
        $customer->gender = $request->gender;
        if ($request->is_active) {
            $customer->is_active = 1;

        }

        $customer->date_of_birth = $request->date_of_birth;
        $customer->roll = $request->roll;

        if ($customer->save()) {

            return redirect()->back()->with(['msg' => 1]);
        } else {
            return redirect()->back()->with(['msg' => 2]);
        }

        return view('customer.edit', compact('customers'));

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
