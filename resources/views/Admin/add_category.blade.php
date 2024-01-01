@extends('layouts.admin_master')

@section('content')

    <div class="mx-5">

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header"><h1 class="text-center font-weight-light my-4"><b>Add Category</b></h1>
                    </div>
                    <div class="card-body">

                        @if (session('message'))
                            <div class="alert {{ session('message_success') ? 'alert-success' : 'alert-danger' }}">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ url('/add-category') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="name">Category Name</label>
                                        <input class="form-control py-4" name="name" type="text" placeholder=""
                                               required/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="small mb-1" for="description">Description</label>
                                        <input class="form-control py-4" name="description" type="text" placeholder=""/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4 mb-0">
                                <button class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>Category ID</th>
                                    <th>Category Name</th>
                                    <th>Category Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($category as $row)
                                    <tr>
                                        <td>{{ $row->id }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info edit-category"
                                                    data-toggle="modal" data-target="#editModal"
                                                    data-id="{{ $row->id }}" data-name="{{ $row->name }}"
                                                    data-description="{{ $row->description }}">
                                                Edit
                                            </button>
                                        </td>
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

    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="editName">Category Name</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editDescription">Description</label>
                            <input type="text" class="form-control" id="editDescription" name="description">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                columnDefs: [
                    {bSortable: false, targets: [2]}
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
                            columns: [0, 1, 2]
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        exportOptions: {
                            modifier: {
                                page: 'current'
                            },
                            columns: [0, 1, 2]
                        }
                    },
                    'print',
                    'colvis'
                ]
            });


            $('.edit-category').click(function () {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var description = $(this).data('description');

                $('#editForm').attr('action', '/update-category/' + id);
                $('#editName').val(name);
                $('#editDescription').val(description);
            });

            // $('#editForm').submit(function (event) {
            //     event.preventDefault();
            //     var formData = $(this).serialize();
            //     $.ajax({
            //         type: 'POST',
            //         url: $(this).attr('action'),
            //         data: formData,
            //         success: function (response) {
            //             $('#editModal').modal('hide');
            //             // Optionally, update the table or perform other actions after successful update
            //         },
            //         error: function (xhr) {
            //             // Handle errors or display validation messages if needed
            //         }
            //     });
            // });
        });


    </script>
@endsection
