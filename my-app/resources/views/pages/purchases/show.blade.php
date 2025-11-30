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
            <strong>Whoops!</strong> There were some problems adding the item.<br><br>
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
            <div class="card">
                <div class="card-header bg-info text-white">
                    General & Financial Summary
                </div>
                <div class="card-body">
                    <p><strong>Supplier:</strong> {{ $purchase->supplier_name }}</p>
                    <p><strong>Date:</strong> {{ $purchase->date->format('d M, Y') }}</p>
                    <p><strong>Note:</strong> {{ $purchase->note ?? 'N/A' }}</p>

                    <hr>
                    <h5>Financials</h5>
                    <table class="table table-sm table-borderless">
                        <tr><th>Total Amount:</th><td class="text-end">{{ number_format($purchase->total_amount, 2) }}</td></tr>
                        <tr><th>Paid Amount:</th><td class="text-end text-success">{{ number_format($purchase->paid_amount, 2) }}</td></tr>
                        <tr><th>Due Amount:</th><td class="text-end text-danger">**{{ number_format($purchase->due_amount, 2) }}**</td></tr>
                        <tr><td colspan="2"><hr class="my-1"></td></tr>
                        <tr><td>Tax ({{ $purchase->tax_percentage }}%):</td><td class="text-end">{{ number_format($purchase->tax_amount, 2) }}</td></tr>
                        <tr><td>Discount ({{ $purchase->discount_percentage }}%):</td><td class="text-end">{{ number_format($purchase->discount_amount, 2) }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Right Column: Add Item Form --}}
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-success text-white">
                    Add Product to Purchase
                </div>
                <div class="card-body">
                    <form action="{{ route('purchases.items.store', $purchase->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Product:</strong>
                                {{-- ধরে নিচ্ছি $products ভিউতে পাঠানো হয়েছে (Product::all() বা অন্য কিছু) --}}
                                <select name="product_id" class="form-control" required>
                                    <option value="">-- Select Product --</option>
                                    {{-- এখানে $products লুপ করতে হবে, যা PurchaseController-এর show/edit মেথড থেকে আসতে পারে --}}
                                    @isset($products)
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->product_name }} ({{ $product->product_code }})
                                            </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <strong>Quantity:</strong>
                                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <strong>Price/Unit (No Tax/Disc):</strong>
                                <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price') }}" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                {{-- অন্যান্য ফিল্ড যেমন unit_price, sub_total, discount_amount, tax_amount এখানে লুকানো থাকতে পারে বা JS দিয়ে গণনা করা যেতে পারে --}}
                                <input type="hidden" name="sub_total" value="0">
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="submit" class="btn btn-sm btn-success">Add Item</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <h3>Purchased Items (Purchase Details)</h3>

            @if ($purchase->purchaseItems->isEmpty())
                <div class="alert alert-warning">No products have been added to this purchase yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product Name (Code)</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Sub Total</th>
                                <th width="100px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase->purchaseItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->product_name }} ({{ $item->product_code }})</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->product_discount_amount, 2) }}</td>
                                <td>{{ number_format($item->product_tax_amount, 2) }}</td>
                                <td>**{{ number_format($item->sub_total, 2) }}**</td>
                                <td>
                                    <form action="{{ route('purchase_details.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this item and revert stock?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="6" class="text-end">**NET TOTAL**</td>
                                <td>**{{ number_format($purchase->purchaseItems->sum('sub_total'), 2) }}**</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
