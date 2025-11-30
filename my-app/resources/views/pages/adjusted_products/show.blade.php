@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Adjustment Entry Details 📑</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('adjusted_products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-info text-white">
            <h4>Entry #{{ $adjustedProduct->id }} for Adjustment #{{ $adjustedProduct->adjustment_id }}</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <p><strong>Product Name:</strong> {{ $adjustedProduct->product->product_name ?? 'N/A' }}</p>
                    <p><strong>Product Code:</strong> {{ $adjustedProduct->product->product_code ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <p><strong>Adjustment Type:</strong>
                        <span class="badge bg-{{ $adjustedProduct->type == 'Addition' ? 'success' : 'danger' }}">
                            {{ $adjustedProduct->type }}
                        </span>
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <p><strong>Quantity Changed:</strong> **{{ $adjustedProduct->quantity }}**</p>
                </div>

                <div class="col-md-12 mt-3">
                    <p><strong>Created At:</strong> {{ $adjustedProduct->created_at->format('d M, Y H:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ $adjustedProduct->updated_at->format('d M, Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
