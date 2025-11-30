@extends('master')

@section('content')
    <div class="container mt-4">
        <h2>Create New Role</h2>

        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label>Guard Name</label>
                <input type="text" name="guard_name" class="form-control @error('guard_name') is-invalid @enderror"
                    value="{{ old('guard_name', 'web') }}">
                @error('guard_name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button class="btn btn-primary">Save Role</button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection