<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Supplier\OrderController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/**
 * CORE DASHBOARD
 * Unified route that handles redirection based on role via the Controller
 */
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    /**
     * USER PROFILE ROUTES
     */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * ADMIN SECTION
     * Prefix: /admin | Name: admin.*
     */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', function () {
            return redirect()->route('admin.suppliers.index');
        });

        // Supplier Management
        Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

        // Order Management (Admin View)
        Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
        Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    /**
     * SUPPLIER SECTION
     * Prefix: /supplier | Name: supplier.*
     */
    Route::prefix('supplier')->name('supplier.')->group(function () {
        // Order Registry (The Index)
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        
        // --- THE MISSING ROUTE ---
        // This displays the Create Form (create.blade.php)
        Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
        
        // This handles the Form Submission
        Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
        
        // Invoicing
        Route::get('/invoices/{order}', [OrderController::class, 'downloadInvoice'])->name('orders.invoice');
    });
});

require __DIR__.'/auth.php';