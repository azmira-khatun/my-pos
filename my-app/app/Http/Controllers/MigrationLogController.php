<?php

namespace App\Http\Controllers;

use App\Models\MigrationLog;
use Illuminate\Http\Request;
use Illuminate\View\View; // Use View for the index method's return type

class MigrationLogController extends Controller
{
    /**
     * Display a listing of the system migration logs.
     * Fetches data from the 'migrations' table via the MigrationLog Model.
     *
     * @return View // Type hint in comment updated to View
     */
    public function index(): View // Type declaration updated to View
    {
        // Retrieve all records from the 'migrations' table
        $logs = MigrationLog::all();

        // Pass the data ($logs) to the Blade file
        return view('migration_logs.index', compact('logs'));
    }

    /*
    public function show(string $id): JsonResponse
    {
        // Note: This method still correctly returns a JsonResponse
        $log = MigrationLog::findOrFail($id); 
        return response()->json($log);
    }
    */
}