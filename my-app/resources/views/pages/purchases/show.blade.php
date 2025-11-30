@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Purchase Details - {{ $purchase->reference }} 🧾</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('purchases.index') }}"> Back to List</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3"><p>{{ $message }}</p></div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger mt-3"><p>{{ $message }}</p></div>
    @endif
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

    <div class="row mt-3">
        {{-- General and Financial Summary --}}
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    General & Financial Summary
                </div>
                <div class="card-body">
                    <p><strong>Supplier:</strong> {{ $purchase->supplier_name }}</p>
                    <p><strong>Date:</strong> {{ $purchase->date->format('d M, Y') }}</p>
                    <p><strong>Order Status:</strong>
                        <span class="badge bg-{{ $purchase->status == 'Completed' ? 'success' : ($purchase->status == 'Pending' ? 'warning' : 'danger') }}">
                            {{ $purchase->status }}
                        </span>
                    </p>
                    <p><strong>Payment Status:</strong>
                        <span class="badge bg-{{ $purchase->payment_status == 'Paid' ? 'success' : ($purchase->payment_status == 'Partial' ? 'info' : 'secondary') }}">
                            {{ $purchase->payment_status }}
                        </span>
                    </p>

                    <hr>
                    <h5>Financials</h5>
                    <table class="table table-sm table-borderless">
                        <tr><th>Total Amount:</th><td class="text-end">{{ number_format($purchase->total_amount, 2) }}</td></tr>
                        <tr><th>Paid Amount:</th><td class="text-end text-success">{{ number_format($purchase->paid_amount, 2) }}</td></tr>
                        <tr><th>Due Amount:</th><td class="text-end text-danger">**{{ number_format($purchase->due_amount, 2) }}**</td></tr>
                        <tr><td colspan="2"><hr class="my-1"></td></tr>
                        <tr><td>Tax ({{ $purchase->tax_percentage }}%):</td><td class="text-end">{{ number_format($purchase->tax_amount, 2) }}</td></tr>
                        <tr><td>Discount ({{ $purchase->discount_percentage }}%):</td><td class="text-end">{{ number_format($purchase->discount_amount, 2) }}</td></tr>
                        <tr><td>Shipping:</td><td class="text-end">{{ number_format($purchase->shipping_amount, 2) }}</td></tr>
                    </table>
                </div>
            </div>

            {{-- Add Item Form is included here as a placeholder for brevity --}}
            <div class="card">
                 <div class="card-header bg-primary text-white">
                    Add/Edit Purchased Items
                </div>
                <div class="card-body">
                    <p class="text-muted">Item management form goes here...</p>
                    {{-- @include('purchases._add_item_form', ['purchase' => $purchase, 'products' => $products]) --}}
                </div>
            </div>
        </div>

        {{-- Right Column: Payment Management --}}
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-warning text-dark">
                    Record New Payment 💰
                </div>
                <div class="card-body">
                    @if ($purchase->due_amount > 0)
                        <form action="{{ route('purchases.payments.store', $purchase->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <strong>Amount (Due: {{ number_format($purchase->due_amount, 2) }}):</strong>
                                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $purchase->due_amount) }}" max="{{ $purchase->due_amount }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>Date:</strong>
                                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <strong>Method:</strong>
                                    <select name="payment_method" class="form-control" required>
                                        <option value="Cash">Cash</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Reference (Optional):</strong>
                                    <input type="text" name="reference" class="form-control" value="{{ old('reference') }}" placeholder="Cheque No / TXN ID">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Note:</strong>
                                    <input type="text" name="note" class="form-control" value="{{ old('note') }}" placeholder="Optional notes">
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-sm btn-success">Record Payment</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-success">This purchase is fully paid.</div>
                    @endif
                </div>
            </div>

            {{-- Payment History --}}
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Payment History
                </div>
                <div class="card-body">
                    @if ($purchase->purchasePayments->isEmpty())
                        <div class="alert alert-info">No payments recorded yet.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Reference</th>
                                        <th width="80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchase->purchasePayments as $payment)
                                    <tr>
                                        <td>{{ $payment->date->format('d M, Y') }}</td>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->reference ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('purchase_payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payment record and revert the due amount?');">X</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
