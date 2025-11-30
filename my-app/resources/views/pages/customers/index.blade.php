@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Customer Management 🧑‍🤝‍🧑</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-success" href="{{ route('customers.create') }}"> Add New Customer</a>
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
        @foreach ($customers as $customer)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $customer->customer_name }}</td>
                <td>{{ $customer->customer_email }}</td>
                <td>{{ $customer->customer_phone }}</td>
                <td>{{ $customer->city }}, {{ $customer->country }}</td>
                <td>
                    <form action="{{ route('customers.destroy',$customer->id) }}" method="POST">
                        <a class="btn btn-info btn-sm" href="{{ route('customers.show',$customer->id) }}">View</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('customers.edit',$customer->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are You Sure?');">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {!! $customers->links() !!}
</div>
@endsection
