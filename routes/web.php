<?php

use App\Http\Controllers\Werehouse\ProductCategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route Werehouse/Gudang
Route::prefix('werehouse')->group(function() {

    // Product Category
    Route::prefix('product-category')->group(function() {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('product-category.index');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
