<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class admin extends Controller
{
    public function getCustomer(Request $r)
    {
        $customer = Customer::find($r->id);

        return response()->json([
            'customer' => $customer,
            'msg' => 'success',
        ]);
    }
}
