@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Product Adjustment Entries 📈</h2>
            </div>
            <div class="float-end">
                {{-- Assuming Adjustment creation is the main flow, or a direct link is needed --}}
                <a class="btn btn-success" href="{{ route('adjusted_products.create') }}"> Create New Adjustment Entry</a>
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
                    <th>Adjustment ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th width="150px">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($adjustedProducts as $entry)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    {{-- Assuming Adjustment model has a name/reference field, here using ID --}}
                    <td><a href="#">#{{ $entry->adjustment_id }}</a></td>
                    <td>{{ $entry->product->product_name ?? 'Product Deleted' }} ({{ $entry->product->product_code ?? 'N/A' }})</td>
                    <td>{{ $entry->quantity }}</td>
                    <td>
                        <span class="badge bg-{{ $entry->type == 'Addition' ? 'success' : 'danger' }}">
                            {{ $entry->type }}
                        </span>
                    </td>
                    <td>{{ $entry->created_at->format('d M, Y') }}</td>
                    <td>
                        <form action="{{ route('adjusted_products.destroy', $entry->id) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('adjusted_products.show', $entry->id) }}">View</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('adjusted_products.edit', $entry->id) }}">Edit</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('WARNING: Deleting this entry will revert the stock change. Are You Sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $adjustedProducts->links() !!}
</div>
@endsection
