@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Edit Purchase Info - {{ $purchase->reference }} 🛠️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('purchases.index') }}"> Back</a>
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

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Date:</strong>
                    <input type="date" name="date" class="form-control" value="{{ old('date', $purchase->date->format('Y-m-d')) }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Reference:</strong>
                    <input type="text" name="reference" class="form-control" placeholder="REF-0001" value="{{ old('reference', $purchase->reference) }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Supplier:</strong>
                    <select name="supplier_id" class="form-control">
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $id => $name)
                            <option value="{{ $id }}" {{ old('supplier_id', $purchase->supplier_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Tax Percentage (%):</strong>
                    <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ old('tax_percentage', $purchase->tax_percentage) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Discount Percentage (%):</strong>
                    <input type="number" step="0.01" name="discount_percentage" class="form-control" value="{{ old('discount_percentage', $purchase->discount_percentage) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Shipping Amount:</strong>
                    <input type="number" step="0.01" name="shipping_amount" class="form-control" value="{{ old('shipping_amount', $purchase->shipping_amount) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Status:</strong>
                    <select name="status" class="form-control">
                        <option value="Pending" {{ old('status', $purchase->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status', $purchase->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status', $purchase->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Total Amount:</strong>
                    <input type="number" step="0.01" name="total_amount" class="form-control" value="{{ old('total_amount', $purchase->total_amount) }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Paid Amount:</strong>
                    <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ old('paid_amount', $purchase->paid_amount) }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Payment Method:</strong>
                    <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method', $purchase->payment_method) }}" placeholder="Cash, Bank, Cheque">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>Note:</strong>
                    <textarea class="form-control" style="height:100px" name="note" placeholder="Any special notes about this purchase">{{ old('note', $purchase->note) }}</textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-success">Update Purchase Info</button>
            </div>
        </div>
    </form>
</div>
@endsection
