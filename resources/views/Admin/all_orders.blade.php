@extends('layouts.admin_master')
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Orders List
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Order Id</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Customer Email</th>
                        <th>Quantity</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($orders as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->product_code }}</td>
                            <td>{{ $row->product_name }}</td>
                            <td>{{ $row->email }}</td>
                            <td>{{ $row->quantity }}</td>
                            <td>
                                @if($row->order_status=='0')
                                    <span class="btn btn-sm btn-info">Pending</span>
                                @else
                                    <span class="btn btn-sm btn-info">Delivered</span>
                                @endif
                            </td>
                            <td>
                                @if($row->order_status=='0')
                                    <a href="{{ 'add-invoice/'.$row->id }}"
                                       class="btn btn-sm btn-info">Create Invoice</a>

                                    <form method="POST" action="{{ route('delete.order', ['id' => $row->id]) }}" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this order?')">
                                            Delete Order
                                        </button>
                                    </form>
                                @else
                                    <span href="#" class="btn btn-sm btn-info">Invoiced</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                columnDefs: [
                    {bSortable: false, targets: [6]}
                ],
                dom: 'lBfrtip',
                buttons: [
                    {
                        extend: 'copyHtml5',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            },
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            },
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            },
                            columns: [0, 1, 2, 5]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            },
                            columns: [0, 1, 2, 3, 4, 5]
                        }
                    },
                    'print',
                    'colvis'
                ]
            });
        });
    </script>
@endsection
