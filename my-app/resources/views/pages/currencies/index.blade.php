@extends('master')

@section('content')
<div class="container">
    <h2>Currency List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('currencies.create') }}" class="btn btn-primary mb-3">Add New Currency</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Code</th>
                <th>Symbol</th>
                <th>Exchange Rate</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($currencies as $currency)
            <tr>
                <td>{{ $currency->currency_name }}</td>
                <td>{{ $currency->code }}</td>
                <td>{{ $currency->symbol }}</td>
                <td>{{ $currency->exchange_rate }}</td>
                <td>
                    <a href="{{ route('currencies.edit', $currency->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('currencies.destroy', $currency->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Confirm delete?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
