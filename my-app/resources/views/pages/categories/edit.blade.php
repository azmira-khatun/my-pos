@extends('master')

@section('content')
<div class="container">
    <h2>Edit Category: {{ $category->category_name }}</h2>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label for="category_code">Category Code <span class="text-danger">*</span></label>
            <input type="text" name="category_code" id="category_code"
                   class="form-control @error('category_code') is-invalid @enderror"
                   value="{{ old('category_code', $category->category_code) }}" required>
            @error('category_code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="category_name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" id="category_name"
                   class="form-control @error('category_name') is-invalid @enderror"
                   value="{{ old('category_name', $category->category_name) }}" required>
            @error('category_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
