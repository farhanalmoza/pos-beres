<?php

use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\WerehouseController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
use App\Http\Controllers\Cashier\ProductController as CashierProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Warehouse\DashboardController as WarehouseDashboardController;
use App\Http\Controllers\Warehouse\ProductController as WarehouseProductController;
use App\Http\Middleware\RolePermission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Product Category
    Route::prefix('product-category')->group(function() {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('admin.product-category.index');
        Route::get('/get-all', [ProductCategoryController::class, 'getAll'])->name('admin.product-category.get-all');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('admin.product-category.store');
        Route::get('/show/{id}', [ProductCategoryController::class, 'show'])->name('admin.product-category.show');
        Route::put('/update/{id}', [ProductCategoryController::class, 'update'])->name('admin.product-category.update');
        Route::delete('/delete/{id}', [ProductCategoryController::class, 'destroy'])->name('admin.product-category.destroy');
    });

    // Product
    Route::prefix('product')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product.index');
        Route::get('/get-all', [ProductController::class, 'getAll'])->name('admin.product.get-all');
        Route::post('/', [ProductController::class, 'store'])->name('admin.product.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('admin.product.show');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');
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
        Route::get('/get-all', [StoreController::class, 'getAll'])->name('admin.store.get-all');
        Route::post('/', [StoreController::class, 'store'])->name('admin.store.store');
        Route::get('/show/{id}', [StoreController::class, 'show'])->name('admin.store.show');
        Route::get('/detail/{id}', [StoreController::class, 'detail'])->name('admin.store.detail');
        Route::put('/update/{id}', [StoreController::class, 'update'])->name('admin.store.update');
        Route::delete('/delete/{id}', [StoreController::class, 'destroy'])->name('admin.store.destroy');
    });

    // Werehouse
    Route::prefix('werehouse')->group(function() {
        Route::get('/', [WerehouseController::class, 'index'])->name('admin.werehouse.index');
        Route::get('/create', [WerehouseController::class, 'create'])->name('admin.werehouse.create');
        Route::get('/edit/{id}', [WerehouseController::class, 'edit'])->name('admin.werehouse.edit');
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

// Route Warehouse
Route::prefix('warehouse')->middleware(['auth', 'role:warehouse'])->group(function() {
    Route::get('/dashboard', [WarehouseDashboardController::class, 'index'])->name('warehouse.dashboard');

    // Product
    Route::prefix('product')->group(function() {
        Route::get('/', [WarehouseProductController::class, 'index'])->name('warehouse.product.index');
    });

    // Product In
    Route::prefix('product-in')->group(function() {
        Route::get('/', [WarehouseProductController::class, 'productIn'])->name('warehouse.product-in.index');
    });

    // Product Out
    Route::prefix('product-out')->group(function() {
        Route::get('/', [WarehouseProductController::class, 'productOut'])->name('warehouse.product-out.index');
    });

    // Product Request
    Route::prefix('product-request')->group(function() {
        Route::get('/', [WarehouseProductController::class, 'productRequest'])->name('warehouse.product-request.index');
    });
});

// Route Cashier
Route::prefix('cashier')->middleware(['auth', 'role:cashier'])->group(function() {
    Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('cashier.dashboard');

    // Cashier
    Route::prefix('cashier')->group(function() {
        Route::get('/', [CashierController::class, 'index'])->name('cashier.index');
    });

    // Product
    Route::prefix('product')->group(function() {
        Route::get('/', [CashierProductController::class, 'index'])->name('cashier.product.index');
        Route::get('/request-stock', [CashierProductController::class, 'requestStock'])->name('cashier.product.request-stock');
    });
});

Auth::routes();

// Profile Route
Route::prefix('profile')->group(function() {
    Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
