@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Supplier Management 🚛</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-success" href="{{ route('suppliers.create') }}"> Add New Supplier</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City, Country</th>
                <th width="200px">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $supplier->supplier_name }}</td>
                <td>{{ $supplier->supplier_email }}</td>
                <td>{{ $supplier->supplier_phone }}</td>
                <td>{{ $supplier->city }}, {{ $supplier->country }}</td>
                <td>
                    <form action="{{ route('suppliers.destroy',$supplier->id) }}" method="POST">
                        <a class="btn btn-info btn-sm" href="{{ route('suppliers.show',$supplier->id) }}">View</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('suppliers.edit',$supplier->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $suppliers->links() !!}
</div>
@endsection
