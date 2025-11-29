@extends('master')

@section('content')
<div class="container">
    <h2>Units List</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('units.create') }}" class="btn btn-primary mb-3">Add New Unit</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Short Name</th>
                <th>Operator</th>
                <th>Operation Value</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
            <tr>
                <td>{{ $unit->id }}</td>
                <td>{{ $unit->name }}</td>
                <td>{{ $unit->short_name }}</td>
                <td>{{ $unit->operator }}</td>
                <td>{{ $unit->operation_value }}</td>
                <td>
                    <a href="{{ route('units.show', $unit->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('units.destroy', $unit->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this unit?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
