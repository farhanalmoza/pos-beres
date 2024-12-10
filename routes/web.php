<?php

use App\Exports\SalesReportExport;
use App\Http\Controllers\Admin\CashierController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductInController;
use App\Http\Controllers\Admin\Report\DeliveryController;
use App\Http\Controllers\Admin\Report\PurchaseController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\TaxController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Cashier\DashboardController as CashierDashboardController;
use App\Http\Controllers\Cashier\ProductController as CashierProductController;
use App\Http\Controllers\Cashier\PurchaseReportController as CashierPurchaseReportController;
use App\Http\Controllers\Cashier\SalesReportController;
use App\Http\Controllers\Cashier\TransactionController;
use App\Http\Controllers\Member\AuthController;
use App\Http\Controllers\Member\ProductController as MemberProductController;
use App\Http\Controllers\Member\SettingController;
use App\Http\Controllers\ProductOutController;
use App\Http\Controllers\ProductRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Warehouse\DashboardController as WarehouseDashboardController;
use App\Http\Controllers\Warehouse\DeliveryReportController;
use App\Http\Controllers\Warehouse\ProductController as WarehouseProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', [
    function () {
        return view('welcome');
    }
]);

// Route Admin
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Supplier
    Route::prefix('supplier')->group(function() {
        Route::get('/', [SupplierController::class, 'index'])->name('admin.supplier.index');
        Route::get('/get-all', [SupplierController::class, 'getAll'])->name('admin.supplier.get-all');
        Route::post('/', [SupplierController::class, 'store'])->name('admin.supplier.store');
        Route::get('/show/{id}', [SupplierController::class, 'show'])->name('admin.supplier.show');
        Route::put('/update/{id}', [SupplierController::class, 'update'])->name('admin.supplier.update');
        Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('admin.supplier.destroy');
    });

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
        Route::get('/get-all', [ProductInController::class, 'getAll'])->name('admin.product-in.get-all');
        Route::post('/', [ProductInController::class, 'store'])->name('admin.product-in.store');
    });

    // Product Out
    Route::prefix('product-out')->group(function() {
        Route::get('/', [ProductOutController::class, 'index'])->name('admin.product-out.index');
        Route::get('/get-all', [ProductOutController::class, 'getAll'])->name('admin.product-out.get-all');
        Route::post('/', [ProductOutController::class, 'store'])->name('admin.product-out.store');
    });

    // Store
    Route::prefix('store')->group(function() {
        Route::get('/', [StoreController::class, 'index'])->name('admin.store.index');
        Route::get('/get-all', [StoreController::class, 'getAll'])->name('admin.store.get-all');
        Route::post('/', [StoreController::class, 'store'])->name('admin.store.store');
        Route::get('/show/{id}', [StoreController::class, 'show'])->name('admin.store.show');
        Route::get('/detail/{id}', [StoreController::class, 'detail'])->name('admin.store.detail');
        Route::get('/store-products/{id}', [StoreController::class, 'getStoreProducts'])->name('admin.store.store-products');
        Route::put('/update/{id}', [StoreController::class, 'update'])->name('admin.store.update');
        Route::delete('/delete/{id}', [StoreController::class, 'destroy'])->name('admin.store.destroy');
    });

    // Werehouse
    Route::prefix('warehouse')->group(function() {
        Route::get('/', [WarehouseController::class, 'index'])->name('admin.warehouse.index');
        Route::get('/get-warehouse', [UserController::class, 'getWarehouse'])->name('admin.warehouse.get-warehouse');

        Route::prefix('report')->group(function() {
            Route::prefix('purchase')->group(function() {
                Route::get('/', [PurchaseController::class, 'index'])->name('admin.warehouse.report.purchase.index');
                Route::get('/get-all', [PurchaseController::class, 'getAll'])->name('admin.warehouse.report.purchase.get-all');
                Route::get('/export', [PurchaseController::class, 'export'])->name('admin.warehouse.report.purchase.export');
            });

            Route::prefix('delivery')->group(function() {
                Route::get('/', [DeliveryController::class, 'index'])->name('admin.warehouse.report.delivery.index');
                Route::get('/get-all', [DeliveryController::class, 'getAll'])->name('admin.warehouse.report.delivery.get-all');
                Route::get('/export', [DeliveryController::class, 'export'])->name('admin.warehouse.report.delivery.export');
            });
        });
    });

    // Cashier
    Route::prefix('cashier')->group(function() {
        Route::get('/', [CashierController::class, 'index'])->name('admin.cashier.index');
        Route::get('/get-cashier', [UserController::class, 'getCashier'])->name('admin.cashier.get-cashier');
    });

    // Member
    Route::prefix('member')->group(function() {
        Route::get('/', [AdminMemberController::class, 'index'])->name('admin.member.index');
        Route::get('/get-all', [AdminMemberController::class, 'getAll'])->name('admin.member.get-all');
        Route::post('/', [AdminMemberController::class, 'store'])->name('admin.member.store');
        Route::delete('/delete/{id}', [AdminMemberController::class, 'destroy'])->name('admin.member.destroy');
        Route::get('/edit/{id}', [AdminMemberController::class, 'edit'])->name('admin.member.edit');
    });

    // User
    Route::prefix('user')->group(function() {
        Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
        Route::get('/show/{id}', [UserController::class, 'show'])->name('admin.user.show');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
    });

    // Tax
    Route::prefix('tax')->group(function() {
        Route::get('/', [TaxController::class, 'index'])->name('admin.tax.index');
        Route::post('/', [TaxController::class, 'updateTax'])->name('admin.tax.update');
    });
});

// Route Warehouse
Route::prefix('warehouse')->middleware(['auth', 'role:warehouse'])->group(function() {
    Route::get('/dashboard', [WarehouseDashboardController::class, 'index'])->name('warehouse.dashboard');

    // Supplier
    Route::prefix('supplier')->group(function() {
        Route::get('/', [SupplierController::class, 'index'])->name('warehouse.supplier.index');
        Route::get('/get-all', [SupplierController::class, 'getAll'])->name('warehouse.supplier.get-all');
        Route::post('/', [SupplierController::class, 'store'])->name('warehouse.supplier.store');
        Route::get('/show/{id}', [SupplierController::class, 'show'])->name('warehouse.supplier.show');
        Route::put('/update/{id}', [SupplierController::class, 'update'])->name('warehouse.supplier.update');
        Route::delete('/delete/{id}', [SupplierController::class, 'destroy'])->name('warehouse.supplier.destroy');
    });

    // Product Category
    Route::prefix('product-category')->group(function() {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('warehouse.product-category.index');
        Route::get('/get-all', [ProductCategoryController::class, 'getAll'])->name('warehouse.product-category.get-all');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('warehouse.product-category.store');
        Route::get('/show/{id}', [ProductCategoryController::class, 'show'])->name('warehouse.product-category.show');
        Route::put('/update/{id}', [ProductCategoryController::class, 'update'])->name('warehouse.product-category.update');
        Route::delete('/delete/{id}', [ProductCategoryController::class, 'destroy'])->name('warehouse.product-category.destroy');
    });

    // Product
    Route::prefix('product')->group(function() {
        Route::get('/', [ProductController::class, 'index'])->name('warehouse.product.index');
        Route::get('/get-all', [ProductController::class, 'getAll'])->name('warehouse.product.get-all');
        Route::post('/', [ProductController::class, 'store'])->name('warehouse.product.store');
        Route::get('/show/{id}', [ProductController::class, 'show'])->name('warehouse.product.show');
        Route::put('/update/{id}', [ProductController::class, 'update'])->name('warehouse.product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('warehouse.product.destroy');

        Route::prefix('request')->group(function() {
            Route::get('/', [ProductRequestController::class, 'productRequestWarehouseView'])->name('warehouse.product.request.index');
            Route::get('/get-all', [ProductRequestController::class, 'getAllWarehouse'])->name('warehouse.product.request.get-all');
            Route::get('/get-request-product/{id}', [ProductRequestController::class, 'getRequestProduct'])->name('warehouse.product.request.get-request-product');
            Route::post('/', [ProductRequestController::class, 'store'])->name('warehouse.product.request.store');
            Route::post('/process', [ProductRequestController::class, 'processRequestProduct'])->name('warehouse.product.request.process');
        });
    });
    
    // Product In
    Route::prefix('product-in')->group(function() {
        Route::get('/', [ProductInController::class, 'index'])->name('warehouse.product-in.index');
        Route::get('/get-all', [ProductInController::class, 'getAll'])->name('warehouse.product-in.get-all');
        Route::post('/', [ProductInController::class, 'store'])->name('warehouse.product-in.store');
    });

    // Product Out
    Route::prefix('product-out')->group(function() {
        Route::get('/', [ProductOutController::class, 'index'])->name('warehouse.product-out.index');
        Route::get('/get-all', [ProductOutController::class, 'getAll'])->name('warehouse.product-out.get-all');
        Route::post('/', [ProductOutController::class, 'store'])->name('warehouse.product-out.store');
    });

    // Store
    Route::prefix('store')->group(function() {
        Route::get('/', [StoreController::class, 'index'])->name('warehouse.store.index');
        Route::get('/get-all', [StoreController::class, 'getAll'])->name('warehouse.store.get-all');
        Route::post('/', [StoreController::class, 'store'])->name('warehouse.store.store');
        Route::get('/show/{id}', [StoreController::class, 'show'])->name('warehouse.store.show');
        Route::get('/detail/{id}', [StoreController::class, 'detail'])->name('warehouse.store.detail');
        Route::get('/store-products/{id}', [StoreController::class, 'getStoreProducts'])->name('warehouse.store.store-products');
    });

    // Product Request
    Route::prefix('product-request')->group(function() {
        Route::get('/', [WarehouseProductController::class, 'productRequest'])->name('warehouse.product-request.index');
    });

    // Report
    Route::prefix('report')->group(function() {
        Route::prefix('purchase')->group(function() {
            Route::get('/', [PurchaseController::class, 'index'])->name('warehouse.report.purchase.index');
            Route::get('/get-all', [PurchaseController::class, 'getAll'])->name('warehouse.report.purchase.get-all');
            Route::get('/export', [PurchaseController::class, 'export'])->name('warehouse.report.purchase.export');
        });

        Route::prefix('delivery')->group(function() {
            Route::get('/', [DeliveryController::class, 'index'])->name('warehouse.report.delivery.index');
            Route::get('/get-all', [DeliveryController::class, 'getAll'])->name('warehouse.report.delivery.get-all');
            Route::get('/export', [DeliveryController::class, 'export'])->name('warehouse.report.delivery.export');
        });
    });
});

// Route Cashier
Route::prefix('cashier')->middleware(['auth', 'role:cashier'])->group(function() {
    Route::get('/dashboard', [CashierDashboardController::class, 'index'])->name('cashier.dashboard');

    // Store
    Route::get('/store/{id}', [StoreController::class, 'show'])->name('cashier.store.detail');

    // Cashier
    Route::prefix('cashier')->group(function() {
        Route::get('/', [CashierController::class, 'index'])->name('cashier.index');
    });

    // Transaction
    Route::prefix('transaction')->group(function() {
        Route::get('/', [TransactionController::class, 'addTransactionForm'])->name('cashier.transaction.add');
        Route::get('/get/carts/{no_invoice}', [TransactionController::class, 'getCarts'])->name('cashier.transaction.get-carts');
        Route::post('/add/cart', [TransactionController::class, 'addToCart'])->name('cashier.transaction.add-to-cart');
        Route::delete('/delete/cart/{id}', [TransactionController::class, 'destroyCart'])->name('cashier.transaction.delete-cart');

        Route::post('/cash', [TransactionController::class, 'processPayment'])->name('cashier.transaction.process-payment');
        Route::delete('/cancel/transaction/{no_invoice}', [TransactionController::class, 'cancelTransaction'])->name('cashier.transaction.cancel-transaction');

        // LIST TRANSACTIONS
        Route::get('/list', [TransactionController::class, 'listTransactionsView'])->name('cashier.transaction.list');
        Route::get('/get-all', [TransactionController::class, 'listTransactions'])->name('cashier.transaction.get-all');
        Route::get('/invoice/{id}', [TransactionController::class, 'invoice'])->name('cashier.transaction.invoice');
        Route::get('/download/invoice/{id}', [TransactionController::class, 'downloadInvoice'])->name('cashier.transaction.download-invoice');
    });

    // Product
    Route::prefix('product')->group(function() {
        Route::get('/', [CashierProductController::class, 'index'])->name('cashier.product.index');
        Route::get('/get-all', [CashierProductController::class, 'getAll'])->name('cashier.product.getAll');
        Route::get('/request-stock', [CashierProductController::class, 'requestStock'])->name('cashier.product.request-stock');

        Route::prefix('request')->group(function() {
            Route::get('/', [ProductRequestController::class, 'productRequestView'])->name('cashier.product.request.index');
            Route::get('/get-all', [ProductRequestController::class, 'getAll'])->name('cashier.product.request.get-all');
            Route::post('/', [ProductRequestController::class, 'store'])->name('cashier.product.request.store');
        });
    });

    // Report
    Route::prefix('report')->group(function() {
        Route::prefix('sale')->group(function() {
            Route::get('/', [SalesReportController::class, 'index'])->name('cashier.report.sale.index');
            Route::get('/get-all', [SalesReportController::class, 'getAll'])->name('cashier.report.sale.get-all');
            Route::get('/export', [SalesReportController::class, 'export'])->name('cashier.report.sale.export');
        });

        Route::prefix('purchase')->group(function() {
            Route::get('/', [CashierPurchaseReportController::class, 'index'])->name('cashier.report.purchase.index');
            Route::get('/get-all', [CashierPurchaseReportController::class, 'getAll'])->name('cashier.report.purchase.get-all');
            Route::get('/export', [CashierPurchaseReportController::class, 'export'])->name('cashier.report.purchase.export');
        });
    });
});

Auth::routes();
// Auth Member Route
Route::prefix('member')->group(function() {
    Route::middleware(['guest'])->group(function() {
        Route::get('/login', [AuthController::class, 'loginForm'])->name('member.loginForm');
        Route::post('/login', [AuthController::class, 'login'])->name('member.login');
    });

    Route::middleware(['member'])->group(function() {
        Route::post('/logout', [AuthController::class, 'logout'])->name('member.logout');
        Route::get('/dashboard', [function () {
                return view('member.dashboard');
             }
        ])->name('member.dashboard');

        Route::prefix('product')->group(function() {
            Route::get('/', [MemberProductController::class, 'index'])->name('member.product.index');
            Route::get('/get-all', [MemberProductController::class, 'getAll'])->name('member.product.get-all');
        });

        Route::prefix('setting')->group(function() {
            Route::get('/change-password', [SettingController::class, 'changePassword'])->name('member.setting.change-password');
            Route::post('/update-password', [SettingController::class, 'updatePassword'])->name('member.setting.update-password');
        });
    });
});

// Profile Route
Route::prefix('profile')->group(function() {
    Route::get('/edit-password', [ProfileController::class, 'editPassword'])->name('profile.edit-password');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::get('/edit-profile', [ProfileController::class, 'editProfile'])->name('profile.edit-profile');
    Route::post('/update-no-telepon', [ProfileController::class, 'updateNoTelp'])->name('profile.update-no-telepon');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
