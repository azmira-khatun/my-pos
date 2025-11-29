<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;

Route::get('/', function () {
    return view('portal');
});
Route::get('/master', function () {
    return view('master');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboardCard');
});

// unit start
Route::resource('units', UnitController::class);
