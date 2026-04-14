<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ======== PUBLIC WEB E-COMMERCE ========

// 1. Landing Page
Route::get('/', function () {
    return view('welcome');
});

// 2. Menu Page & API
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/api/products', [MenuController::class, 'products'])->name('api.products');

// 3. Cart & Checkout
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::get('/order/{orderCode}', [CartController::class, 'confirmation'])->name('order.confirmation');

// ======== CAFE MANAGEMENT (FILAMENT) ========

// Dashboard redirect to Filament
Route::get('/dashboard', function () {
    return redirect('/admin');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes (via Breeze, optional since Filament provides its own auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
