@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Return Details - {{ $purchaseReturn->reference }} 🧾</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('purchase_returns.index') }}"> Back to List</a>
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
        {{-- Left Column: Summary and Financials --}}
        <div class="col-md-5">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    General & Financial Summary
                </div>
                <div class="card-body">
                    <p><strong>Supplier:</strong> {{ $purchaseReturn->supplier_name }}</p>
                    <p><strong>Date:</strong> {{ $purchaseReturn->date->format('d M, Y') }}</p>
                    <p><strong>Note:</strong> {{ $purchaseReturn->note ?? 'N/A' }}</p>

                    <hr>
                    <h5>Financials</h5>
                    <table class="table table-sm table-borderless">
                        <tr><th>Total Return Value:</th><td class="text-end">{{ number_format($purchaseReturn->total_amount, 2) }}</td></tr>
                        <tr><th>Amount Refunded:</th><td class="text-end text-success">{{ number_format($purchaseReturn->paid_amount, 2) }}</td></tr>
                        <tr><th>Credit Due From Supplier:</th><td class="text-end text-danger">**{{ number_format($purchaseReturn->due_amount, 2) }}**</td></tr>
                    </table>
                </div>
            </div>

            {{-- Returned Items List (Item Management section for PurchaseReturnDetail) --}}
             <div class="card">
                <div class="card-header bg-primary text-white">
                    Returned Items List
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                         @if ($purchaseReturn->returnItems->isEmpty())
                            <div class="alert alert-warning m-3">No items specified for this return yet.</div>
                         @else
                            <table class="table table-sm table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Sub Total</th>
                                        <th>Act.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($purchaseReturn->returnItems as $item)
                                    <tr>
                                        <td>{{ $item->product_name }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ number_format($item->sub_total, 2) }}</td>
                                        <td>
                                            <form action="{{ route('purchase_return_details.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm p-0 px-1" onclick="return confirm('Delete item and revert stock?');">X</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                         @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Refund Management --}}
        <div class="col-md-7">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    Record Supplier Refund 💰
                </div>
                <div class="card-body">
                    @if ($purchaseReturn->due_amount > 0)
                        <form action="{{ route('purchase_returns.payments.store', $purchaseReturn->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <strong>Amount (Due from Supplier: {{ number_format($purchaseReturn->due_amount, 2) }}):</strong>
                                    <input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', $purchaseReturn->due_amount) }}" max="{{ $purchaseReturn->due_amount }}" required>
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
                                        <option value="Credit Applied">Credit Applied</option>
                                    </select>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <strong>Reference / Note:</strong>
                                    <input type="text" name="reference" class="form-control" value="{{ old('reference') }}" placeholder="Cheque No / TXN ID / Credit Note Ref">
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-sm btn-success">Record Refund</button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-info">The supplier has fully refunded or settled the credit for this return.</div>
                    @endif
                </div>
            </div>

            {{-- Refund History --}}
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    Refund/Credit History
                </div>
                <div class="card-body">
                    @if ($purchaseReturn->returnPayments->isEmpty())
                        <div class="alert alert-info">No refund records yet.</div>
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
                                    @foreach ($purchaseReturn->returnPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->date->format('d M, Y') }}</td>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ $payment->payment_method }}</td>
                                        <td>{{ $payment->reference ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('purchase_return_payments.destroy', $payment->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm p-0 px-1" onclick="return confirm('Are you sure you want to delete this refund record?');">X</button>
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
