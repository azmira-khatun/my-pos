@extends('master')

@section('content')
<div class="container">
    <h2>Create New Category</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="category_code">Category Code <span class="text-danger">*</span></label>
            <input type="text" name="category_code" class="form-control @error('category_code') is-invalid @enderror" value="{{ old('category_code') }}" required>
            @error('category_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="category_name">Category Name <span class="text-danger">*</span></label>
            <input type="text" name="category_name" class="form-control @error('category_name') is-invalid @enderror" value="{{ old('category_name') }}" required>
            @error('category_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save Category</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
