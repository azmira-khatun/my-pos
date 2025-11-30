<?php

namespace App\Http\Controllers;

use App\Models\MigrationLog; // Make sure this Model class exists
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse; // Use this for better type hinting (optional but good practice)

class MigrationLogController extends Controller
{
    /**
     * Display a listing of the system migration logs.
     * Fetches data from the 'migrations' table via the MigrationLog Model.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        // Retrieve all records from the 'migrations' table
        $logs = MigrationLog::all();

        return response()->json([
            'message' => 'System Migration History',
            'total_migrations' => $logs->count(),
            'data' => $logs
        ]);
    }

    /*
    public function show(string $id): JsonResponse
    {
        // Note: findOrFail will throw an exception if the ID is not found (a 404 response)
        $log = MigrationLog::findOrFail($id); 
        return response()->json($log);
    }
    */
}