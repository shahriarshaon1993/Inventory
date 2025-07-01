<?php

use App\Http\Controllers\JournalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleItemController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class)
        ->except('show');

    Route::resource('sales', SaleController::class)
        ->except('show', 'edit', 'update');

    Route::get('sale-items', SaleItemController::class)->name('sale-items.index');

    Route::get('stocks', StockController::class)->name('stocks.index');

    Route::get('payments', PaymentController::class)->name('payments.index');

    Route::get('journals', JournalController::class)->name('journals.index');
});

require __DIR__.'/auth.php';
