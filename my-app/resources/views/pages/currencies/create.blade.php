@extends('master')

@section('content')
<div class="container">
    <h2>Create New Currency</h2>

    <form action="{{ route('currencies.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="currency_name">Currency Name</label>
            <input type="text" name="currency_name" class="form-control @error('currency_name') is-invalid @enderror" value="{{ old('currency_name') }}" required>
            @error('currency_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="code">Code (e.g., BDT)</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required>
            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="symbol">Symbol (e.g., ৳)</label>
            <input type="text" name="symbol" class="form-control @error('symbol') is-invalid @enderror" value="{{ old('symbol') }}" required>
            @error('symbol') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="exchange_rate">Exchange Rate (to Base Currency)</label>
            <input type="number" step="0.000001" name="exchange_rate" class="form-control @error('exchange_rate') is-invalid @enderror" value="{{ old('exchange_rate', 1.00) }}" required>
            @error('exchange_rate') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Save Currency</button>
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
