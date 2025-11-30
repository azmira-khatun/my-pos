@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Edit Role</h2>

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}">
            </div>

            <div class="mb-3">
                <label>Guard Name</label>
                <input type="text" name="guard_name" class="form-control"
                    value="{{ old('guard_name', $role->guard_name) }}">
            </div>

            <button class="btn btn-primary">Update Role</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection