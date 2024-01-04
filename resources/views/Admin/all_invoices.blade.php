@extends('layouts.admin_master')
@section('content')
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table mr-1"></i>
        Invoices List
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Invoice No.</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Company</th>
                        <th>Address</th>
                        <!-- <th>Total_Price</th> -->
                        <th>Product Name</th>
                        <!-- <th>Sales Stock Price</th> -->
                        <th>Quantity</th>
                        <th>Total Cost</th>
                        <th>Due</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                	@foreach($invoices as $row)
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->customer_name }}</td>
                        <td>{{ $row->customer_mail }}</td>
                        <td>{{ $row->company }}</td>
                        <td>{{ $row->address }}</td>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->quantity }}</td>
                        <td>{{ $row->total }}</td>
                        <td>{{ $row->due }}</td>
                        <td>{{ $row->created_at }}</td>
                        <td>
                            @if($row->due > 0)
                                <a href="{{ route('pay.due', ['id' => $row->id]) }}" class="btn btn-primary">Pay Due</a>
                            @else
                                <a href="{{ route('invoice.details', ['id' => $row->id]) }}" class="btn btn-primary">Show Invoice</a>
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
                    {bSortable: false, targets: [10]}
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
                            columns: [0, 1, 2, 3, 4, 5,6,7,8,9]
                        }
                    },
                    'print',
                    'colvis'
                ]
            });
        });
    </script>
@endsection
