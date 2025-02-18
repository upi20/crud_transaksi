<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;

// Routing untuk halaman utama
Route::get('/', function () {
    return redirect()->route('products.index');
});

Route::resource('products', ProductController::class);
Route::resource('transactions', TransactionController::class);
Route::get('transactions/{transaction}/details', [TransactionDetailController::class, 'index'])->name('transaction_details.index');
Route::post('transactions/{transaction}/details', [TransactionDetailController::class, 'store'])->name('transaction_details.store');
Route::delete('transactions/{transaction}/details/{detail}', [TransactionDetailController::class, 'destroy'])->name('transaction_details.destroy');
