@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Edit Adjustment Entry 🛠️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('adjusted_products.index') }}"> Back</a>
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

    <form action="{{ route('adjusted_products.update', $adjustedProduct->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Adjustment Reference ID:</strong>
                    <select name="adjustment_id" class="form-control">
                        <option value="">-- Select Adjustment ID --</option>
                        @foreach ($adjustments as $id)
                            <option value="{{ $id }}" {{ old('adjustment_id', $adjustedProduct->adjustment_id) == $id ? 'selected' : '' }}>#{{ $id }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Product:</strong>
                    {{-- Note: Usually the product_id should not be changed for an existing pivot entry --}}
                    <select name="product_id" class="form-control">
                        <option value="">-- Select Product --</option>
                        @foreach ($products as $id => $name)
                            <option value="{{ $id }}" {{ old('product_id', $adjustedProduct->product_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Adjustment Type:</strong>
                    <select name="type" class="form-control">
                        <option value="">-- Select Type --</option>
                        <option value="Addition" {{ old('type', $adjustedProduct->type) == 'Addition' ? 'selected' : '' }}>Addition (Stock Increase)</option>
                        <option value="Subtraction" {{ old('type', $adjustedProduct->type) == 'Subtraction' ? 'selected' : '' }}>Subtraction (Stock Decrease)</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Quantity to Adjust:</strong>
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" value="{{ old('quantity', $adjustedProduct->quantity) }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-success">Update Adjustment</button>
            </div>
        </div>
    </form>
</div>
@endsection
