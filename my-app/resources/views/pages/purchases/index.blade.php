@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Purchase Records 📄</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-success" href="{{ route('purchases.create') }}"> Create New Purchase</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3"><p>{{ $message }}</p></div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger mt-3"><p>{{ $message }}</p></div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th>Due</th>
                    <th>Status</th>
                    <th>P. Status</th>
                    <th width="200px">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $purchase->date->format('d M, Y') }}</td>
                    <td><strong class="text-primary">{{ $purchase->reference }}</strong></td>
                    <td>{{ $purchase->supplier_name }}</td>
                    <td>{{ number_format($purchase->total_amount, 2) }}</td>
                    <td>{{ number_format($purchase->due_amount, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $purchase->status == 'Completed' ? 'success' : ($purchase->status == 'Pending' ? 'warning' : 'danger') }}">
                            {{ $purchase->status }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $purchase->payment_status == 'Paid' ? 'success' : ($purchase->payment_status == 'Partial' ? 'info' : 'secondary') }}">
                            {{ $purchase->payment_status }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('purchases.show', $purchase->id) }}">View/Edit Items</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('purchases.edit', $purchase->id) }}">Edit Info</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('WARNING: Deleting this may affect stock records. Are You Sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $purchases->links() !!}
</div>
@endsection
