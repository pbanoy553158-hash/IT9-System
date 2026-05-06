<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Supplier\OrderController;
use App\Http\Controllers\Supplier\ProductController;
use App\Http\Controllers\Supplier\InvoiceController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | ADMIN PANEL
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/', fn () => redirect()->route('admin.suppliers.index'));

        /* REPORTS */
        Route::get('/reports', [AdminReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/supplier-performance', [AdminReportController::class, 'supplierPerformance'])
            ->name('reports.supplier-performance');

        /* DASHBOARD ACTIONS */
        Route::delete('/activity/clear', [DashboardController::class, 'clearActivity'])
            ->name('activity.clear');

        /*
        |--------------------------------------------------------------------------
        | SUPPLIERS
        |--------------------------------------------------------------------------
        */
        Route::get('/suppliers', [SupplierController::class, 'index'])
            ->name('suppliers.index');

        Route::post('/suppliers', [SupplierController::class, 'store'])
            ->name('suppliers.store');

        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])
            ->name('suppliers.edit');

        Route::patch('/suppliers/{supplier}', [SupplierController::class, 'update'])
            ->name('suppliers.update');

        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
            ->name('suppliers.destroy');

        /* PRODUCTS (ADMIN) */
        Route::get('/products', [AdminProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/create', [AdminProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [AdminProductController::class, 'store'])
            ->name('products.store');

        Route::patch('/products/{product}/approve', [AdminProductController::class, 'approve'])
            ->name('products.approve');

        Route::patch('/products/{product}/reject', [AdminProductController::class, 'reject'])
            ->name('products.reject');

        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])
            ->name('products.destroy');

        /* ORDERS (ADMIN VIEW) */
        Route::get('/orders', [OrderController::class, 'adminIndex'])
            ->name('orders.index');

        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.update-status');
    });

    /*
    |--------------------------------------------------------------------------
    | SUPPLIER PANEL
    |--------------------------------------------------------------------------
    */
    Route::prefix('supplier')->name('supplier.')->group(function () {

        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');

        Route::get('/orders/create', [OrderController::class, 'create'])
            ->name('orders.create');

        Route::post('/orders', [OrderController::class, 'store'])
            ->name('orders.store');

        Route::post('/cart/add', [OrderController::class, 'addToCart'])
            ->name('cart.add');

        Route::get('/cart', [OrderController::class, 'cart'])
            ->name('cart.index');

        Route::post('/cart/checkout', [OrderController::class, 'checkout'])
            ->name('cart.checkout');

        Route::patch('/orders/{order}/update', [OrderController::class, 'quickUpdate'])
            ->name('orders.update');

        Route::get('/products', [ProductController::class, 'index'])
            ->name('products.index');

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}', [ProductController::class, 'show'])
            ->name('products.show');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::patch('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        Route::get('/invoices', [InvoiceController::class, 'index'])
            ->name('invoices.index');

        Route::get('/invoices/{order}', [InvoiceController::class, 'show'])
            ->name('invoices.show');
    });
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';