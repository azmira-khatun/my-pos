@extends('master')

@section('content')
<div class="container">
    <h2>Unit Details: {{ $unit->name }}</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $unit->id }}</p>
            <p><strong>Name:</strong> {{ $unit->name }}</p>
            <p><strong>Short Name:</strong> {{ $unit->short_name }}</p>
            <p><strong>Operator:</strong> {{ $unit->operator }}</p>
            <p><strong>Operation Value:</strong> {{ $unit->operation_value }}</p>
            <p><strong>Created At:</strong> {{ $unit->created_at->format('d M, Y H:i') }}</p>
            <p><strong>Updated At:</strong> {{ $unit->updated_at->format('d M, Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('units.index') }}" class="btn btn-secondary">Back to List</a>
        <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-warning">Edit Unit</a>
    </div>
</div>
@endsection
