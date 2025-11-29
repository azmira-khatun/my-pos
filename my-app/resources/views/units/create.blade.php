@extends('master')

@section('content')
<div class="container">
    <h2>Create New Unit</h2>

    <form action="{{ route('units.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="name">Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="short_name">Short Name</label>
            <input type="text" name="short_name" id="short_name" class="form-control" value="{{ old('short_name') }}">
        </div>

        <div class="form-group mb-3">
            <label for="operator">Operator (e.g., *, /)</label>
            <input type="text" name="operator" id="operator" class="form-control" value="{{ old('operator') }}">
        </div>

        <div class="form-group mb-3">
            <label for="operation_value">Operation Value (e.g., 1000)</label>
            <input type="text" name="operation_value" id="operation_value" class="form-control" value="{{ old('operation_value') }}">
        </div>

        <button type="submit" class="btn btn-success">Save Unit</button>
        <a href="{{ route('units.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
