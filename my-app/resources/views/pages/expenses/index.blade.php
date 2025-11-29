@extends('master')

@section('content')
<div class="container">
    <h2>Expense List</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Record New Expense</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Category</th>
                <th>Reference</th>
                <th>Details</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expenses as $expense)
            <tr>
                <td>{{ $expense->date->format('d M, Y') }}</td>
                {{-- রিলেশনশিপ ব্যবহার করে ক্যাটেগরি নাম দেখানো হয়েছে --}}
                <td>{{ $expense->category->category_name ?? 'N/A' }}</td>
                <td>{{ $expense->reference }}</td>
                <td>{{ Str::limit($expense->details, 40) }}</td>
                <td>{{ number_format($expense->amount, 2) }}</td>
                <td>
                    <a href="{{ route('expenses.edit', $expense->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" style="display:inline-block;">
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
