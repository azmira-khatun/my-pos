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
use App\Http\Controllers\AdjustmentController;

use App\Http\Controllers\SupplierController;

use App\Http\Controllers\AdjustedProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseItemController;
use App\Http\Controllers\PurchasePaymentController;


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

// AdjustedProduct

Route::resource('adjusted_products', AdjustedProductController::class);

// ... আপনার অন্য routes ...

Route::resource('adjustments', AdjustmentController::class);

// Purchase

Route::resource('purchases', PurchaseController::class);

// Purchase Item Management Routes
// store: একটি নির্দিষ্ট ক্রয়ের মধ্যে একটি নতুন আইটেম যোগ করা
Route::post('purchases/{purchase}/items', [PurchaseItemController::class, 'store'])
    ->name('purchases.items.store');

// destroy: একটি নির্দিষ্ট আইটেম মুছে ফেলা (PurchaseDetail মডেল আইডি ব্যবহার করে)
Route::delete('purchase_details/{purchaseDetail}', [PurchaseItemController::class, 'destroy'])
    ->name('purchase_details.destroy');


// Purchase Payment Management Routes
// store: একটি নির্দিষ্ট ক্রয়ের জন্য একটি নতুন পেমেন্ট যোগ করা
Route::post('purchases/{purchase}/payments', [PurchasePaymentController::class, 'store'])
    ->name('purchases.payments.store');

// destroy: একটি নির্দিষ্ট পেমেন্ট এন্ট্রি মুছে ফেলা (PurchasePayment মডেল আইডি ব্যবহার করে)
Route::delete('purchase_payments/{purchasePayment}', [PurchasePaymentController::class, 'destroy'])
    ->name('purchase_payments.destroy');

// ... (আপনার অন্য routes, যেমন Route::resource('purchases', PurchaseController::class);)
