@extends('layouts.admin_master')

@section('content')

    <main>
        <div class="container-fluid">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Stock</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('all.product') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Sold Products</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('sold.products') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Categories</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('add.category') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Pending Orders</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('pending.orders') }}">View
                                Details</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-4 mb-2">
                    <div class="card mb-4" style="height: 100%;">
                        <div class="card-header">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Stock Level
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 mb-2">
                    <div class="card mb-4" style="height: 100%;">
                        <div class="card-header">
                            <i class="fas fa-chart-area mr-1"></i>
                            Unit Price
                        </div>
                        <div class="card-body">
                            <canvas id="myUnitPriceChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 mb-2">
                    <div class="card mb-4" style="height: 100%;">
                        <div class="card-header">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Sales Unit Price
                        </div>
                        <div class="card-body">
                            <canvas id="mySalesUnitPriceChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 mb-2">
                    <div class="card mb-4" style="height: 100%;">
                        <div class="card-header">
                            <i class="fas fa-chart-bar mr-1"></i>
                            Order Status
                        </div>
                        <div class="card-body">
                            <canvas id="myOrderStatusChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-xl-8 mb-2">
                    <div class="card mb-4" style="height: 100%;">
                        <div class="card-header">
                            <i class="fas fa-table mr-1"></i>
                            Monthly Order Counts
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Total Orders</th>
                                        <th>Order Status</th>
                                    </tr>
                                    </thead>
                                    <tfoot>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Total Orders</th>
                                        <th>Order Status</th>
                                    </tr>
                                    </tfoot>
                                    <tbody>
                                    @foreach($monthlyOrderCounts as $orderCount)
                                        <tr>
                                            <td>{{ $orderCount->year }}</td>
                                            <td>{{ $months[$orderCount->month] }}</td>
                                            <td>{{ $orderCount->total_orders }}</td>
                                            <td>{{ $orderCount->order_status_label }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')

    <script>
        // Set new default font family and font color to mimic Bootstrap's default styling
        Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#292b2c';

        // Bar Chart Example


        // Bar Chart for Stock Levels
        var ctxStock = document.getElementById("myBarChart");
        var stockChart = new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: {!! $products->pluck('name') !!},
                datasets: [{
                    label: "Stock Levels",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: {!! $products->pluck('stock') !!},
                }],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        var ctxUnitPrice = document.getElementById("myUnitPriceChart");
        var unitPriceChart = new Chart(ctxUnitPrice, {
            type: 'line',
            data: {
                labels: {!! $unitPrices->pluck('name') !!},
                datasets: [{
                    label: "Unit Prices",
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: {!! $unitPrices->pluck('unit_price') !!},
                }],
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });

        // Pie Chart for Sales Unit Prices
        var ctxSalesUnitPrice = document.getElementById("mySalesUnitPriceChart");
        var salesUnitPriceChart = new Chart(ctxSalesUnitPrice, {
            type: 'pie',
            data: {
                labels: {!! $salesUnitPrices->pluck('name') !!},
                datasets: [{
                    data: {!! $salesUnitPrices->pluck('sales_unit_price') !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        // Add more colors if needed
                    ],
                }],
            },
        });


        var ctxOrderStatus = document.getElementById("myOrderStatusChart");
        var orderStatusChart = new Chart(ctxOrderStatus, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($orderStatusData as $status)
                        @if($status->order_status === 1)
                        'Delivered',
                    @else
                        'Pending',
                    @endif
                    @endforeach
                ],
                datasets: [{
                    data: {!! $orderStatusData->pluck('total') !!},
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)', // Pending color
                        'rgba(54, 162, 235, 0.8)', // Delivered color
                        // Add more colors if needed
                    ],
                }],
            },
        });


    </script>
@endsection
