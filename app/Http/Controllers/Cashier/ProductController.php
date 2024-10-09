<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
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
}
