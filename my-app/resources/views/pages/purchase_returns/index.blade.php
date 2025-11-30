@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Purchase Returns Records ↩️</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-danger" href="{{ route('purchase_returns.create') }}"> Record New Return</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3"><p>{{ $message }}</p></div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Supplier</th>
                    <th>Total Value</th>
                    <th>Credit Due</th>
                    <th>Refund Status</th>
                    <th width="180px">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($returns as $return)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $return->date->format('d M, Y') }}</td>
                    <td><strong class="text-danger">{{ $return->reference }}</strong></td>
                    <td>{{ $return->supplier_name }}</td>
                    <td>{{ number_format($return->total_amount, 2) }}</td>
                    <td>{{ number_format($return->due_amount, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $return->payment_status == 'Refunded' ? 'success' : 'secondary' }}">
                            {{ $return->payment_status }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('purchase_returns.destroy', $return->id) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('purchase_returns.show', $return->id) }}">View/Edit Items</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('purchase_returns.edit', $return->id) }}">Edit Info</a>

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

    {!! $returns->links() !!}
</div>
@endsection
