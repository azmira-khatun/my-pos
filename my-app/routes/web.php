<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portal');
});
Route::get('/master', function () {
    return view('master');
});
Route::get('/dashboard', function () {
    return view('pages.dashboard.dashboardCard');
});
