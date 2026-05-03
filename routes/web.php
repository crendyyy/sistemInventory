<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CashTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    
    Route::resource('purchases', PurchaseController::class);
    Route::post('purchases/{purchase}/payment', [PurchaseController::class, 'addPayment'])->name('purchases.payment');
    Route::post('purchases/{purchase}/receive', [PurchaseController::class, 'receiveInden'])->name('purchases.receive');
    Route::resource('sales', SaleController::class);
    Route::post('sales/{sale}/payment', [SaleController::class, 'addPayment'])->name('sales.payment');
    Route::resource('cash-transactions', CashTransactionController::class);
    Route::patch('cash-transactions/{cash_transaction}/cancel', [CashTransactionController::class, 'cancel'])->name('cash-transactions.cancel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
