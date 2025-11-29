@extends('master')

@section('content')
<div class="container">
    <h2>System Settings</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- কোম্পানি ইনফরমেশন --}}
        <div class="card mb-4">
            <div class="card-header">Company Information</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="company_name">Company Name</label>
                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $settings->company_name) }}">
                </div>
                <div class="form-group mb-3">
                    <label for="company_email">Company Email</label>
                    <input type="email" name="company_email" class="form-control" value="{{ old('company_email', $settings->company_email) }}">
                </div>
                <div class="form-group mb-3">
                    <label for="company_phone">Company Phone</label>
                    <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone', $settings->company_phone) }}">
                </div>
                <div class="form-group mb-3">
                    <label for="company_address">Company Address</label>
                    <textarea name="company_address" class="form-control" rows="3">{{ old('company_address', $settings->company_address) }}</textarea>
                </div>
            </div>
        </div>

        {{-- কারেন্সি ও ডিসপ্লে সেটিংস --}}
        <div class="card mb-4">
            <div class="card-header">Display & Currency Settings</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="default_currency_id">Default Currency</label>
                    <select name="default_currency_id" class="form-control">
                        <option value="">-- Select Currency --</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ old('default_currency_id', $settings->default_currency_id) == $currency->id ? 'selected' : '' }}>
                                {{ $currency->currency_name }} ({{ $currency->code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="default_currency_position">Currency Symbol Position</label>
                    <select name="default_currency_position" class="form-control">
                        <option value="prefix" {{ old('default_currency_position', $settings->default_currency_position) == 'prefix' ? 'selected' : '' }}>Prefix (e.g., $100)</option>
                        <option value="suffix" {{ old('default_currency_position', $settings->default_currency_position) == 'suffix' ? 'selected' : '' }}>Suffix (e.g., 100$)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- লোগো ও অন্যান্য --}}
        <div class="card mb-4">
            <div class="card-header">Logo & Footer</div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="site_logo">Site Logo (Max 2MB, JPG/PNG)</label>
                    <input type="file" name="site_logo" class="form-control-file">
                    @if ($settings->site_logo)
                        <small class="d-block mt-2">Current Logo:</small>
                        <img src="{{ asset('storage/' . $settings->site_logo) }}" alt="Site Logo" style="max-width: 150px; border: 1px solid #ddd; padding: 5px;">
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="notification_email">Notification Email</label>
                    <input type="email" name="notification_email" class="form-control" value="{{ old('notification_email', $settings->notification_email) }}">
                </div>
                <div class="form-group mb-3">
                    <label for="footer_text">Footer Text</label>
                    <input type="text" name="footer_text" class="form-control" value="{{ old('footer_text', $settings->footer_text) }}">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Settings</button>
    </form>
</div>
@endsection
