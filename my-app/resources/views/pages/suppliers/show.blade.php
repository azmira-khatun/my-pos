@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Supplier Details ℹ️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('suppliers.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $supplier->supplier_name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $supplier->supplier_email }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Phone:</strong>
                        {{ $supplier->supplier_phone ?? 'Not Provided' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>City, Country:</strong>
                        {{ $supplier->city ?? 'Not Provided' }}, {{ $supplier->country ?? 'Not Provided' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Address:</strong>
                        {{ $supplier->address ?? 'Not Provided' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Created At:</strong>
                        {{ $supplier->created_at->format('d M, Y H:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
