@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Product Details ℹ️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            <h4>{{ $product->product_name }} ({{ $product->product_code }})</h4>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Product Information --}}
                <div class="col-md-6">
                    <h5>**General Info**</h5>
                    <p><strong>Category:</strong> {{ $product->category->category_name ?? 'N/A' }}</p>
                    <p><strong>Unit:</strong> {{ $product->product_unit ?? 'N/A' }}</p>
                    <p><strong>Barcode Symbology:</strong> {{ $product->product_barcode_symbology ?? 'N/A' }}</p>
                    <p><strong>Product Note:</strong> {{ $product->product_note ?? 'None' }}</p>
                </div>

                {{-- Pricing and Stock --}}
                <div class="col-md-6">
                    <h5>**Pricing & Stock**</h5>
                    <p><strong>Cost Price:</strong> ${{ number_format($product->product_cost, 2) }}</p>
                    <p><strong>Selling Price:</strong> ${{ number_format($product->product_price, 2) }}</p>
                    <p><strong>Current Quantity:</strong> {{ $product->product_quantity }}</p>
                    <p>
                        <strong>Stock Alert:</strong> {{ $product->product_stock_alert }}
                        @if ($product->product_quantity <= $product->product_stock_alert)
                            <span class="badge bg-warning text-dark">ACTION REQUIRED</span>
                        @endif
                    </p>
                    <p><strong>Order Tax:</strong> {{ $product->product_order_tax }}% ({{ $product->product_tax_type ?? 'N/A' }})</p>
                </div>

                <div class="col-md-12 mt-4">
                    <p><strong>Created At:</strong> {{ $product->created_at->format('d M, Y H:i A') }}</p>
                    <p><strong>Last Updated:</strong> {{ $product->updated_at->format('d M, Y H:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
