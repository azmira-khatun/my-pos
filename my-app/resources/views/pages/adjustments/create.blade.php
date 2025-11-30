@extends('master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>New Stock Adjustment ➕➖</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-primary" href="{{ route('adjustments.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('adjustments.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Date:</strong>
                    <input type="date" name="date" class="form-control" value="{{ old('date', date('Y-m-d')) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 mb-3">
                <div class="form-group">
                    <strong>Reference (e.g., ADJ-2025/001):</strong>
                    <input type="text" name="reference" class="form-control" placeholder="Adjustment Reference" value="{{ old('reference') }}">
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
                <div class="form-group">
                    <strong>Note:</strong>
                    <textarea class="form-control" style="height:100px" name="note" placeholder="Reason for adjustment, e.g., Annual stock take correction">{{ old('note') }}</textarea>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-success">Save Adjustment Info</button>
            </div>
        </div>
    </form>
</div>
@endsection
