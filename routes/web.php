<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OwnerController;

/*
|--------------------------------------------------------------------------
| Customer (Publik - tanpa login)
|--------------------------------------------------------------------------
*/
Route::get('/', [MenuController::class, 'indexWeb'])->name('menu.index');
Route::get('/search', [MenuController::class, 'search'])->name('menu.search');

// Keranjang & Order (Web) - customer pesan tanpa perlu login
Route::post('/cart/add/{id}', [OrderController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/minus/{id}', [OrderController::class, 'minusFromCart'])->name('cart.minus');
Route::post('/cart/reset', [OrderController::class, 'resetCart'])->name('cart.reset');
Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
Route::get('/order/{order}', [OrderController::class, 'showWeb'])->name('order.show'); // nota untuk customer

/*
|--------------------------------------------------------------------------
| Auth (Login Owner)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Owner (Butuh login & role owner)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerController::class, 'dashboard'])->name('dashboard');

    // Kelola Menu
    Route::get('/menu', [MenuController::class, 'ownerIndex'])->name('menu.index');
    Route::get('/menu/create', [MenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [MenuController::class, 'storeWeb'])->name('menu.store');
    Route::get('/menu/{menu}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [MenuController::class, 'updateWeb'])->name('menu.update');
    Route::delete('/menu/{menu}', [MenuController::class, 'destroyWeb'])->name('menu.destroy');

    // Pesanan Masuk
    Route::get('/orders', [OrderController::class, 'viewCart'])->name('orders.index');
    Route::post('/orders/{order}/complete', [OrderController::class, 'completeOrder'])->name('orders.complete');
});

use App\Http\Controllers\TableController;

// Admin routes
Route::get('/admin/tables', [TableController::class, 'index'])->name('admin.tables.index');
Route::post('/admin/tables/generate-all', [TableController::class, 'generateAllQR'])->name('admin.tables.generate-all');
Route::post('/admin/tables/{id}/generate-qr', [TableController::class, 'generateQR'])->name('admin.tables.generate-qr');

// Customer order route
Route::get('/pesan', [OrderController::class, 'index'])->name('order.index');