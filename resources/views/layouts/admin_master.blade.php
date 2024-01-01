<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Inventory Management System</title>

    <link href="{{ asset('css/dashboard-styles.css') }}" rel="stylesheet"/>
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet"
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.0/css/buttons.dataTables.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
            crossorigin="anonymous"></script>
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand">Inventory Management System</a>
    <!-- Navbar Search-->
    <div class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </div>
    <!-- Navbar-->
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                @if(Auth::check() && Auth::user()->profile_picture)
                    <img src="{{ asset(Auth::user()->profile_picture) }}" alt="Profile Image"
                         style="width: 32px; height: 32px; border-radius: 50%;">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor"
                         class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zm0 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1z"/>
                        <path
                            d="M8 7a2 2 0 1 1-3 1.732A2 2 0 0 1 8 7zm0 1.5a.5.5 0 1 0 0 1 .5.5 0 0 0 0-1zM3.5 9a4.5 4.5 0 1 0 5 4.472 5.5 5.5 0 0 1-7-4.94.5.5 0 0 0 .5.468h1zm9 0a.5.5 0 0 0 .5-.468 5.5 5.5 0 0 1-7 4.94A4.5 4.5 0 1 0 3.5 9h1a3.5 3.5 0 1 1 7 0h1z"/>
                    </svg>
                @endif
                @if(Auth::check())
                    {{ Auth::user()->name }}
                @endif
            </a>
            <div>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('settings.edit') }}">Settings</a>
                    <a class="dropdown-item" href="{{ route('activity.log') }}">Activity Log</a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                    </form>
                </div>
            </div>
        </li>
    </ul>

</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Interface</div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
                       aria-expanded="false" aria-controls="collapseProducts">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Products
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseProducts" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('add.product') }}">New Product</a>
                            <a class="nav-link" href="{{ route('all.product') }}">Stock Report</a>
                            <a class="nav-link" href="{{ route('available.products') }}">Available Products</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
                       aria-expanded="false" aria-controls="collapseCategory">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Categories
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCategory" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('add.category') }}">Add Category</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOrders"
                       aria-expanded="false" aria-controls="collapseOrders">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Orders
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseOrders" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('new.order')}}">New Order</a>
                            <a class="nav-link" href="{{ route('all.orders')}}">Orders List</a>
                            <a class="nav-link" href="{{ route('pending.orders')}}">Pending Orders</a>
                            <a class="nav-link" href="{{ route('delivered.orders')}}">Delivered Orders</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice"
                       aria-expanded="false" aria-controls="collapseInvoice">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Sales
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseInvoice" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('all.invoices') }}">Invoices List</a>
                        </nav>
                    </div>

                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAuthentication"
                       aria-expanded="false" aria-controls="collapseAuthentication">
                        <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                        Customers
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseAuthentication" aria-labelledby="headingOne"
                         data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{ route('add.customer') }}">New Customer</a>
                            <a class="nav-link" href="{{ route('all.customers') }}">Customers List</a>
                        </nav>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">

        @yield('content')

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Blue Bird</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/dashboard-scripts.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-bar-demo.js') }}"></script>
<script src="{{ asset('assets/demo/chart-pie-demo.js') }}"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25em 0.5em;
        margin-left: 1px;
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background-color: #007bff;
        color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #007bff;
        color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        color: #6c757d;
        cursor: not-allowed;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        border-radius: 4px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {
        background-color: #007bff;
        color: #ffffff;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        background-color: transparent;
        color: #6c757d;
    }

    .dataTables_wrapper .dt-buttons .buttons-html5,
    .dataTables_wrapper .dt-buttons .buttons-html5:hover,
    .dataTables_wrapper .dt-buttons .buttons-html5:focus {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: #fff;
    }

    .dataTables_wrapper .dt-buttons .buttons-csv,
    .dataTables_wrapper .dt-buttons .buttons-csv:hover,
    .dataTables_wrapper .dt-buttons .buttons-csv:focus {
        background-color: #28a745;
        border-color: #28a745;
        color: #fff;
    }

    .dataTables_wrapper .dt-buttons .buttons-html5:hover,
    .dataTables_wrapper .dt-buttons .buttons-csv:hover {
        background-color: #138496;
        border-color: #138496;
    }

    .dataTables_wrapper .dt-buttons .buttons-html5:focus,
    .dataTables_wrapper .dt-buttons .buttons-csv:focus {
        background-color: #106669;
        border-color: #106669;
    }
</style>
@yield('script')
</body>
</html>
