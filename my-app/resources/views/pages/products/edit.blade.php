@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Edit Product 🛠️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="row">
            {{-- General Details --}}
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="category_id" class="form-control">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id', $product->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Product Name:</strong>
                    <input type="text" name="product_name" class="form-control" placeholder="Product Name" value="{{ old('product_name', $product->product_name) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Product Code:</strong>
                    <input type="text" name="product_code" class="form-control" placeholder="Product Code (e.g. SKU)" value="{{ old('product_code', $product->product_code) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Unit:</strong>
                    <input type="text" name="product_unit" class="form-control" placeholder="Unit (e.g. Pcs, Kg)" value="{{ old('product_unit', $product->product_unit) }}">
                </div>
            </div>

            <hr class="mt-3 mb-3">

            {{-- Pricing & Stock --}}
            <div class="col-xs-12 col-sm-12 col-md-4 mb-3">
                <div class="form-group">
                    <strong>Cost Price ($):</strong>
                    <input type="number" step="0.01" name="product_cost" class="form-control" placeholder="Cost Price" value="{{ old('product_cost', $product->product_cost) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 mb-3">
                <div class="form-group">
                    <strong>Selling Price ($):</strong>
                    <input type="number" step="0.01" name="product_price" class="form-control" placeholder="Selling Price" value="{{ old('product_price', $product->product_price) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 mb-3">
                <div class="form-group">
                    <strong>Current Quantity:</strong>
                    <input type="number" name="product_quantity" class="form-control" placeholder="Quantity" value="{{ old('product_quantity', $product->product_quantity) }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-4 mb-3">
                <div class="form-group">
                    <strong>Stock Alert:</strong>
                    <input type="number" name="product_stock_alert" class="form-control" placeholder="Minimum stock level" value="{{ old('product_stock_alert', $product->product_stock_alert) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 mb-3">
                <div class="form-group">
                    <strong>Order Tax (%):</strong>
                    <input type="number" step="0.01" name="product_order_tax" class="form-control" placeholder="Tax Percentage" value="{{ old('product_order_tax', $product->product_order_tax) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 mb-3">
                <div class="form-group">
                    <strong>Tax Type:</strong>
                    <select name="product_tax_type" class="form-control">
                        <option value="">-- Select Tax Type --</option>
                        <option value="Exclusive" {{ old('product_tax_type', $product->product_tax_type) == 'Exclusive' ? 'selected' : '' }}>Exclusive</option>
                        <option value="Inclusive" {{ old('product_tax_type', $product->product_tax_type) == 'Inclusive' ? 'selected' : '' }}>Inclusive</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                <div class="form-group">
                    <strong>Product Note:</strong>
                    <textarea class="form-control" style="height:100px" name="product_note" placeholder="Any special notes or description">{{ old('product_note', $product->product_note) }}</textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
</div>
@endsection
