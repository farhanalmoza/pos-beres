<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductRequestController extends Controller
{
    // STORE
    public function productRequestView() {
        $products = Product::all();
        return view('cashier.product.request', compact('products'));
    }

    public function getAll() {
        $results = ProductRequest::with('product')
            ->where('store_id', Auth::user()->store_id);
        $results = $results->orderBy('created_at', 'desc')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('date', function($rows) {
            return $rows->created_at->format('d-m-Y');
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        ProductRequest::create([
            'product_id' => $request->product_id,
            'store_id' => Auth::user()->store_id,
            'quantity' => $request->quantity,
            'status' => 'pending',
        ]);

        return response(['message' => 'Permintaan barang berhasil!'], 200);
    }
    // END STORE
}
