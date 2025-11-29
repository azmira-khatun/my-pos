@extends('master')

@section('content')
<div class="container">
    <h2>Create New Expense Category</h2>

    <form action="{{ route('expense_categories.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="category_name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name') }}" required>
            @error('category_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="category_description">Description</label>
            <textarea name="category_description" class="form-control @error('category_description') is-invalid @enderror" rows="3">{{ old('category_description') }}</textarea>
            @error('category_description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save Category</button>
        <a href="{{ route('expense_categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
