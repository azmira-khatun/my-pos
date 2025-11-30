<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\SupplierController;



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
// Currency start
Route::resource('currencies', CurrencyController::class);

// Category start
Route::resource('categories', CategoryController::class);
// ExpenseCategory
Route::resource('expense_categories', ExpenseCategoryController::class);

// expense start

Route::resource('expenses', ExpenseController::class);

// Setting start
Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
// routes/api.php

// user start
Route::resource('users', UserController::class);
// role start
Route::resource('roles', RoleController::class);


// customer start

Route::resource('customers', CustomerController::class);


// supplier start

Route::resource('suppliers', SupplierController::class);

//product

Route::resource('products', ProductController::class);
