<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOut;
use App\Models\Store;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductOutController extends Controller
{
    public function index() {
        $stores = Store::all();
        $products = Product::where('quantity', '>', 0)->get();
        if (Auth::user()->role == 'admin') {
            return view('admin.product-out.index', compact('stores', 'products'));
        } else {
            return view('warehouse.product-out.index', compact('stores', 'products'));
        }
    }

    public function getAll() {
        $results = ProductOut::select("id", "store_id", "product_id", "quantity", "created_at")->with(['product', 'store']);
        $results = $results->orderBy('created_at', 'desc')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('total', function($rows) {
            return $rows->quantity * $rows->product->price;
        })
        ->addColumn('date_out', function($rows) {
            return $rows->created_at->format('d-m-Y');
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'store_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        // cek stok barang
        $product = Product::find($request->product_id);
        if ($product->quantity < $request->quantity) {
            return response(['message' => 'Stok barang tidak cukup'], 400);
        }

        DB::beginTransaction();
        try {
            ProductOut::create([
                'store_id' => $request->store_id,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);

            $product = Product::find($request->product_id);
            $product->quantity = $product->quantity - $request->quantity;
            $product->save();

            $store_product = StoreProduct::where('store_id', $request->store_id)->where('product_id', $request->product_id)->first();
            if ($store_product) {
                $store_product->quantity = $store_product->quantity + $request->quantity;
                $store_product->save();
            } else {
                StoreProduct::create([
                    'store_id' => $request->store_id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                ]);
            }
            DB::commit();
            return response(['message' => 'Berhasil mengirim barang ke toko'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => 'Gagal mengirim barang ke toko'], 400);
        }
        DB::commit();
    }
}
