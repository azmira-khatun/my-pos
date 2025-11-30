@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Record New Purchase Return 📝</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('purchase_returns.index') }}"> Back</a>
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

    <form action="{{ route('purchase_returns.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="row">
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Date:</strong>
                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Reference (Unique):</strong>
                    <input type="text" name="reference" class="form-control" placeholder="PRF-0001" value="{{ old('reference') }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Supplier:</strong>
                    <select name="supplier_id" class="form-control">
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $id => $name)
                            <option value="{{ $id }}" {{ old('supplier_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Tax Percentage (%):</strong>
                    <input type="number" step="0.01" name="tax_percentage" class="form-control" value="{{ old('tax_percentage', 0) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Discount Percentage (%):</strong>
                    <input type="number" step="0.01" name="discount_percentage" class="form-control" value="{{ old('discount_percentage', 0) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Shipping Cost (if applicable):</strong>
                    <input type="number" step="0.01" name="shipping_amount" class="form-control" value="{{ old('shipping_amount', 0) }}">
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="form-group">
                    <strong>Return Status:</strong>
                    <select name="status" class="form-control">
                        <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Total Return Value:</strong>
                    <input type="number" step="0.01" name="total_amount" class="form-control" value="{{ old('total_amount') }}" placeholder="Must be calculated based on items">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Amount Refunded Now:</strong>
                    <input type="number" step="0.01" name="paid_amount" class="form-control" value="{{ old('paid_amount', 0) }}">
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="form-group">
                    <strong>Refund Method:</strong>
                    <input type="text" name="payment_method" class="form-control" value="{{ old('payment_method') }}" placeholder="Cash, Bank, Cheque (if applicable)">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>Note:</strong>
                    <textarea class="form-control" style="height:100px" name="note" placeholder="Reason for return, condition of goods, etc.">{{ old('note') }}</textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-success">Save Return Info</button>
            </div>
        </div>
    </form>
</div>
@endsection
