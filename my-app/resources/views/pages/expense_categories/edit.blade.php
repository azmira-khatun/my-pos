@extends('master')

@section('content')
<div class="container">
    <h2>Edit Expense Category: {{ $expenseCategory->category_name }}</h2>

    <form action="{{ route('expense_categories.update', $expenseCategory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="category_name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" id="category_name"
                   class="form-control @error('category_name') is-invalid @enderror"
                   value="{{ old('category_name', $expenseCategory->category_name) }}" required>
            @error('category_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="category_description">Description</label>
            <textarea name="category_description" id="category_description"
                      class="form-control @error('category_description') is-invalid @enderror"
                      rows="3">{{ old('category_description', $expenseCategory->category_description) }}</textarea>
            @error('category_description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Category</button>
        <a href="{{ route('expense_categories.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
