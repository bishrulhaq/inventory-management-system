<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::select('name', 'stock')->get();
        $unitPrices = Product::select('name', 'unit_price')->get();
        $salesUnitPrices = Product::select('name', 'sales_unit_price')->get();
        return view('dashboard', compact('products', 'unitPrices', 'salesUnitPrices'));
    }
}
