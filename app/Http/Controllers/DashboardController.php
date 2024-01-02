<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::select('name', 'stock')->get();
        $unitPrices = Product::select('name', 'unit_price')->get();
        $salesUnitPrices = Product::select('name', 'sales_unit_price')->get();

        $monthlyOrderCounts = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('CASE
                              WHEN order_status = 1 THEN "Delivered"
                              ELSE "Pending"
                          END as order_status_label')
        )
            ->groupBy('year', 'month', 'order_status')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Mapping month numbers to month names
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        $orderStatusData = Order::select('order_status', DB::raw('count(*) as total'))
            ->groupBy('order_status')
            ->get();

        return view('dashboard', compact('products', 'unitPrices', 'salesUnitPrices', 'monthlyOrderCounts', 'orderStatusData', 'months'));
    }
}
