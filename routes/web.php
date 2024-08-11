<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInController;
use App\Http\Controllers\Admin\StoreController;
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
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
