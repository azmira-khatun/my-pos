@extends('master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="float-start">
                <h2>Stock Adjustments List 📑</h2>
            </div>
            <div class="float-end">
                <a class="btn btn-success" href="{{ route('adjustments.create') }}"> Create New Adjustment</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-3"><p>{{ $message }}</p></div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger mt-3"><p>{{ $message }}</p></div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Date</th>
                    <th>Reference</th>
                    <th>Note Preview</th>
                    <th>Last Updated</th>
                    <th width="180px">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($adjustments as $adjustment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $adjustment->date->format('d M, Y') }}</td>
                    <td><strong class="text-primary">{{ $adjustment->reference }}</strong></td>
                    <td>{{ Str::limit($adjustment->note, 50) ?? 'N/A' }}</td>
                    <td>{{ $adjustment->updated_at->format('d M, Y') }}</td>
                    <td>
                        <form action="{{ route('adjustments.destroy', $adjustment->id) }}" method="POST">
                            <a class="btn btn-info btn-sm" href="{{ route('adjustments.show', $adjustment->id) }}">View/Edit Products</a>
                            <a class="btn btn-primary btn-sm" href="{{ route('adjustments.edit', $adjustment->id) }}">Edit Info</a>

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('WARNING: Deleting this will delete all related product adjustments. Are You Sure?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {!! $adjustments->links() !!}
</div>
@endsection
