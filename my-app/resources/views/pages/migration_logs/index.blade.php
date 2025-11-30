@extends('master')

@section('content')
    <div class="container">
        <h2>💾 System Migration History</h2>
        <p class="mb-4">This table shows all executed migrations recorded in the <code>migrations</code> table.</p>

        {{-- Optional: Show Total Count --}}
        <div class="alert alert-info" role="alert">
            Total Migrations Executed: <strong>{{ $logs->count() }}</strong>
        </div>

        {{-- Table to display the data --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Migration File</th>
                        <th>Batch Number</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Check if there are any logs to display --}}
                    @if ($logs->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">No migration records found.</td>
                        </tr>
                    @else
                        {{-- Loop through the collection of logs passed from the controller --}}
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td><code>{{ $log->migration }}</code></td>
                                <td><span class="badge bg-primary">{{ $log->batch }}</span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Example of a link back to a dashboard or main page --}}
        <a href="/" class="btn btn-secondary mt-3">Go to Dashboard</a>
    </div>
@endsection