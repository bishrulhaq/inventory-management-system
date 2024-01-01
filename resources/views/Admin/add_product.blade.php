@extends('layouts.admin_master')

@section('content')

    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card shadow-lg border-1 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Add New Product</h3>
                        </div>
                        <div class="card-body">

                            @if (session('message'))
                                <div class="alert {{ session('message_success') ? 'alert-success' : 'alert-danger' }}">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ url('/insert-product') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="code">Product Code</label>
                                            <input class="form-control py-4" name="code" type="text" placeholder=""/>
                                            @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="name">Product Name</label>
                                            <input class="form-control py-4" name="name" type="text" placeholder=""/>
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="category">Category</label>
                                            <select class="form-control" id="categorySelect" name="category">
                                                <option value="">Select a category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->name }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="stock">Stock</label>
                                            <input class="form-control py-4" name="stock" type="text" placeholder=""/>
                                            @error('stock')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="unit_price">Buy Price (perUnit)</label>
                                            <input class="form-control py-4" name="unit_price" type="text"
                                                   placeholder=""/>
                                            @error('unit_price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="small mb-1" for="inputLastName">Sale Price(perUnit)</label>
                                            <input class="form-control py-4" name="sale_price" type="text"
                                                   placeholder=""/>
                                            @error('sale_price')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
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

