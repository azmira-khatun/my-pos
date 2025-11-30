@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Customer Details ℹ️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('customers.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Name:</strong>
                        {{ $customer->customer_name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $customer->customer_email }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Phone:</strong>
                        {{ $customer->customer_phone ?? 'Not Provided' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>City, Country:</strong>
                        {{ $customer->city ?? 'Not Provided' }}, {{ $customer->country ?? 'Not Provided' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Address:</strong>
                        {{ $customer->address ?? 'Not Provided' }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Created At:</strong>
                        {{ $customer->created_at->format('d M, Y H:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
