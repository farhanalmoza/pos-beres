<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index() {
        return view('cashier.product.index');
    }

    public function getAll() {
        $store_id = Auth::user()->store_id;
        $results = StoreProduct::select("product_id", "quantity")->where("store_id", $store_id)->with('product')->get();
        return datatables()
        ->of($results)
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function requestStock(Request $request) {
        return view('cashier.product.request-stock');
    }

    // WAREHOUSE PRODUCT
    public function warehouseProduct() {
        return view('cashier.warehouse-product.index');
    }

    public function getWarehouseProducts() {
        $results = Product::where('quantity', '>', 0)->get();
        return datatables()
        ->of($results)
        ->make(true);
    }
    // END WAREHOUSE PRODUCT
}
