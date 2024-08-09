<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route Admin
Route::prefix('admin')->group(function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Product Category
    Route::prefix('product-category')->group(function() {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('admin.product-category.index');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
