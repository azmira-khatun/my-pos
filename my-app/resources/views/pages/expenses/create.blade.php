@extends('master')

@section('content')
<div class="container">
    <h2>Record New Expense</h2>

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="category_id">Expense Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="date">Date <span class="text-danger">*</span></label>
            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', date('Y-m-d')) }}" required>
            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="amount">Amount <span class="text-danger">*</span></label>
            <input type="number" step="0.01" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required>
            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="reference">Reference</label>
            <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" value="{{ old('reference') }}">
            @error('reference') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="details">Details</label>
            <textarea name="details" class="form-control @error('details') is-invalid @enderror" rows="3">{{ old('details') }}</textarea>
            @error('details') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save Expense</button>
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
