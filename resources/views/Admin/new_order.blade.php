@extends('layouts.admin_master')

@section('content')

<main>
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-10">
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header"><h3 class="text-center font-weight-light my-4">New Order</h3></div>
        <div class="card-body">
            <div id="loader" class="mb-5" style="display: none; text-align: center;">
                <i class="fas fa-spinner fa-spin" style="font-size: 48px;"></i>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{url('/insert-new-order') }}" enctype="multipart/form-data">
            @csrf
                    <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1" for="inputFirstName">Customer Name</label>
                            <select id="name" name="name" class="form-control">
                                <option selected>Choose...</option>
                                @foreach($customers as $c)
                                    <option value="{{$c->id}}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                        <div class="col-md-6">
                        <div class="form-group" id="email">
                            <!-- <label class="small mb-1" for="inputFirstName">Customer Email</label>
                            <input class="form-control py-4" name="email" type="text"/> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="company">
                            <!-- <label class="small mb-1" for="inputLastName">Company</label>
                            <input class="form-control py-4" name="company" type="text" /> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="address">
                            <!-- <label class="small mb-1" for="inputState">Address</label>
                            <input class="form-control py-4" name="address" type="text" /> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" id="phone">
                            <!-- <label class="small mb-1" for="inputState">Phone No.</label>
                            <input class="form-control py-4" name="phone" type="text" /> -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1" for="inputState">Product Code</label>
                            <select id="inputState" name="code" class="form-control">
                            <option selected value="">Choose...</option>
                            @foreach($products as $row)
                                @if( $row->stock > 1)
                                    <option>{{ $row->product_code }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1" for="inputState">Product Name</label>
                            <select id="inputState" name="name" class="form-control">
                            <option selected value="">Choose...</option>
                            @foreach($products as $row)
                                @if( $row->stock > 1)
                                    <option value="{{$row->name}}">{{ $row->name }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="small mb-1" for="inputLastName">Quantity</label>
                            <input class="form-control py-4" name="quantity" type="text"  />
                        </div>
                    </div>
                </div>

                <div class="form-group mt-4 mb-0"><button class="btn btn-primary btn-block">Submit</button></div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</main>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('name').addEventListener('change', function () {
            var loader = document.getElementById('loader');
            loader.style.display = 'block'; // Show loader

            var c_name = document.getElementById('name').value;
            console.log(c_name);
            axios.post('http://127.0.0.1:8000/api/get-customer', {
                id: c_name
            })
                .then(function (response) {
                    document.getElementById('email').innerHTML = '<label class="small mb-1" for="inputFirstName">Customer Email</label>' +
                        '<input class="form-control py-4" name="email" value="' + response.data.customer.email + '" type="text"/>';

                    document.getElementById('company').innerHTML = '<label class="small mb-1" for="inputFirstName">Customer company</label>' +
                        '<input class="form-control py-4" name="company" value="' + response.data.customer.company + '" type="text"/>';

                    document.getElementById('phone').innerHTML = '<label class="small mb-1" for="inputFirstName">Customer Phone</label>' +
                        '<input class="form-control py-4" name="phone" value="' + response.data.customer.phone + '" type="text"/>';

                    document.getElementById('address').innerHTML = '<label class="small mb-1" for="inputFirstName">Customer Address</label>' +
                        '<input class="form-control py-4" name="address" value="' + response.data.customer.address + '" type="text"/>';
                    loader.style.display = 'none';
                })
                .catch(function (error) {
                    console.error(error);
                    loader.style.display = 'none';
                });
        });
    });
</script>
@endsection
