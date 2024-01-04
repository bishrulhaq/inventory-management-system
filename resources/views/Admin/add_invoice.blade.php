@extends('layouts.admin_master')

@section('content')

    <main>
        <div class="mx-5">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4"><b>Create New
                                    Invoice</b></h3></div>
                        <div class="card-body">

                            @if (session('message'))
                                <div class="alert {{ session('message_success') ? 'alert-success' : 'alert-danger' }}">
                                    {{ session('message') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
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

                            <form method="POST" action="{{url('/insert-invoice') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="id">Order ID</label>
                                            <input class="form-control py-4" name="order_id" type="text" readonly
                                                   value="{{ $id }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="customer">Customer Name</label>
                                            <input class="form-control py-4" name="customer" type="text"
                                                   value="{{ $customer->name }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="email">Customer Email</label>
                                            <input class="form-control py-4" name="email" type="email"
                                                   readonly
                                                   value="{{ $customer->email }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="company">Company</label>
                                            <input class="form-control py-4" name="company" type="text"
                                                   value="{{ $customer->company }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="address">Address</label>
                                            <input class="form-control py-4" name="address" type="text"
                                                   value="{{ $customer->address }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="phone">Phone No.</label>
                                            <input class="form-control py-4" name="phone" type="text"
                                                   value="{{ $customer->phone }}"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="item">Product Category</label>
                                            <input class="form-control py-4" name="item" type="text"
                                                   value="{{ $product->category }}" readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="product_code">Product Code</label>
                                            <input class="form-control py-4" name="product_code" type="text"
                                                   value="{{ $product->product_code }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="name">Product Name</label>
                                            <input class="form-control py-4" name="name" type="text"
                                                   value="{{ $product->name }}" readonly/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="unit_price">Price (perUnit)</label>
                                            <input class="form-control py-4" name="unit_price" type="text"
                                                   value="{{ $product->unit_price }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="quantity">Quantity</label>
                                            <input class="form-control py-4" name="quantity" type="text"
                                                   value="{{ $order->quantity }}"/>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="total">Total Price</label>
                                            <input class="form-control py-4" name="total" type="text"
                                                   value="{{ $product->unit_price * $order->quantity }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="payment">Payment</label>
                                            <input class="form-control py-4" name="payment" type="text" placeholder=""/>
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
        </div>
    </main>

@endsection
@section('script')
    <script>
        // Get input elements
        const unitPriceInput = document.querySelector('input[name="unit_price"]');
        const quantityInput = document.querySelector('input[name="quantity"]');
        const totalPriceInput = document.querySelector('input[name="total"]');

        // Function to calculate total price and update the total input
        function updateTotalPrice() {
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const quantity = parseInt(quantityInput.value) || 0;
            const total = unitPrice * quantity;
            totalPriceInput.value = total.toFixed(2); // Set the total with 2 decimal places
        }

        // Event listeners to trigger the calculation when inputs change
        unitPriceInput.addEventListener('input', updateTotalPrice);
        quantityInput.addEventListener('input', updateTotalPrice);

        // Initially calculate and set the total price based on default values
        updateTotalPrice();
    </script>
@endsection
