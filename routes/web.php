<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/landing', function () {
    return view('landing');
});

Route::get('/cart', function () {
    return view('cart');
});

Route::get('/seats', function () {
    return view('seats');
});

Route::get('/manual', function () {
    return view('manual');
});

Route::get('/account', function () {
    return view('account');
});

Route::get('/login-preview', function () {
    return view('login');
});

Route::get('/dashboard-preview', function (Illuminate\Http\Request $request) {
    // We provide a fallback user object if they aren't logged in but previewing
    return view('dashboard', [
        'user' => $request->user() ?? (object)['name' => 'Demo User', 'email' => 'demo@example.com']
    ]);
});

Route::get('/dashboard', function (Illuminate\Http\Request $request) {
    return view('dashboard', ['user' => $request->user()]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
