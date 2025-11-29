@extends('master')

@section('content')
<div class="container">
    <h2>Edit Currency: {{ $currency->currency_name }}</h2>

    {{-- ফর্মটি বিদ্যমান কারেন্সির ডেটা আপডেট করার জন্য ব্যবহৃত হবে --}}
    <form action="{{ route('currencies.update', $currency->id) }}" method="POST">
        @csrf
        {{-- Laravel-এ ডেটা আপডেট করার জন্য অবশ্যই @method('PUT') ব্যবহার করতে হয় --}}
        @method('PUT')

        <div class="form-group mb-3">
            <label for="currency_name">Currency Name <span class="text-danger">*</span></label>
            {{-- value-তে অবশ্যই বিদ্যমান ডেটা বা old() ভ্যালু দেখাতে হবে --}}
            <input type="text" name="currency_name" id="currency_name"
                   class="form-control @error('currency_name') is-invalid @enderror"
                   value="{{ old('currency_name', $currency->currency_name) }}" required>
            @error('currency_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="code">Code (e.g., BDT) <span class="text-danger">*</span></label>
            <input type="text" name="code" id="code"
                   class="form-control @error('code') is-invalid @enderror"
                   value="{{ old('code', $currency->code) }}" required>
            @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="symbol">Symbol (e.g., ৳) <span class="text-danger">*</span></label>
            <input type="text" name="symbol" id="symbol"
                   class="form-control @error('symbol') is-invalid @enderror"
                   value="{{ old('symbol', $currency->symbol) }}" required>
            @error('symbol')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="thousand_separator">Thousand Separator (e.g., ,)</label>
            <input type="text" name="thousand_separator" id="thousand_separator"
                   class="form-control"
                   value="{{ old('thousand_separator', $currency->thousand_separator) }}">
        </div>

        <div class="form-group mb-3">
            <label for="decimal_separator">Decimal Separator (e.g., .)</label>
            <input type="text" name="decimal_separator" id="decimal_separator"
                   class="form-control"
                   value="{{ old('decimal_separator', $currency->decimal_separator) }}">
        </div>

        <div class="form-group mb-3">
            <label for="exchange_rate">Exchange Rate (to Base Currency) <span class="text-danger">*</span></label>
            <input type="number" step="0.000001" name="exchange_rate" id="exchange_rate"
                   class="form-control @error('exchange_rate') is-invalid @enderror"
                   value="{{ old('exchange_rate', $currency->exchange_rate) }}" required>
            @error('exchange_rate')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update Currency</button>
        <a href="{{ route('currencies.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
