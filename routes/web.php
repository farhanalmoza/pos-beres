<?php

use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route Admin
Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Product Category
    Route::prefix('product-category')->group(function() {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('admin.product-category.index');
    });

    // Product
    Route::prefix('product')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
    });
    
    // Product In
    Route::prefix('product-in')->group(function() {
        Route::get('/', [ProductInController::class, 'index'])->name('admin.product-in.index');
        Route::get('/create', [ProductInController::class, 'create'])->name('admin.product-in.create');
        Route::get('/edit/{id}', [ProductInController::class, 'edit'])->name('admin.product-in.edit');
    });

    // Store
    Route::prefix('store')->group(function() {
        Route::get('/', [StoreController::class, 'index'])->name('admin.store.index');
        Route::get('/create', [StoreController::class, 'create'])->name('admin.store.create');
        Route::get('/edit/{id}', [StoreController::class, 'edit'])->name('admin.store.edit');
    });

    // Cashier
    Route::prefix('cashier')->group(function() {
        Route::get('/', [CashierController::class, 'index'])->name('admin.cashier.index');
        Route::get('/create', [CashierController::class, 'create'])->name('admin.cashier.create');
        Route::get('/edit/{id}', [CashierController::class, 'edit'])->name('admin.cashier.edit');
    });

    // Member
    Route::prefix('member')->group(function() {
        Route::get('/', [MemberController::class, 'index'])->name('admin.member.index');
        Route::get('/create', [MemberController::class, 'create'])->name('admin.member.create');
        Route::get('/edit/{id}', [MemberController::class, 'edit'])->name('admin.member.edit');
    });
});

Auth::routes();

// Profile Route
Route::prefix('profile')->group(function() {
    Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
