<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductOut;
use App\Models\ProductRequest;
use App\Models\Store;
use App\Models\StoreProduct;
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

    // WAREHOUSE
    public function productRequestWarehouseView() {
        $products = Product::all();
        $stores = Store::all();
        return view('warehouse.product.request', compact('products', 'stores'));
    }

    public function getAllWarehouse() {
        $results = ProductRequest::with('product', 'store');
        $results = $results->orderBy('created_at', 'desc')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('date', function($rows) {
            return $rows->created_at->format('d-m-Y');
        })
        ->addColumn('actions', function($rows) {
            $btn = '<button class="btn btn-primary btn-sm process-request-modal-btn" data-bs-toggle="modal" data-bs-target="#processRequestModal" data-id="'.$rows->id.'">Proses</button>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function getRequestProduct($id) {
        $requestProduct = ProductRequest::find($id);
        if (!$requestProduct) return response()->json(['message' => 'Data permintaan tidak ditemukan'], 404);
        return response($requestProduct);
    }

    public function processRequestProduct(Request $request) {
        // check request product
        $requestProduct = ProductRequest::find($request->id);
        if (!$requestProduct) return response()->json(['message' => 'Data permintaan tidak ditemukan'], 404);
        // check product
        $product = Product::find($requestProduct->product_id);
        if (!$product) return response()->json(['message' => 'Data barang tidak ditemukan'], 404);
        // check store
        $store = Store::find($requestProduct->store_id);
        if (!$store) return response()->json(['message' => 'Data toko tidak ditemukan'], 404);

        // check quantity
        if ($requestProduct->quantity > $product->quantity) return response()->json(['message' => 'Jumlah permintaan lebih besar dari jumlah barang yang tersedia'], 400);

        DB::beginTransaction();
        try {
            // create product out
            ProductOut::create([
                'store_id' => $requestProduct->store_id,
                'product_id' => $requestProduct->product_id,
                'quantity' => $request->quantity,
            ]);

            // update stock in warehouse
            $product->quantity = $product->quantity - $request->quantity;
            $product->save();

            // update stock in store
            $storeProduct = StoreProduct::where('store_id', $requestProduct->store_id)->where('product_id', $requestProduct->product_id)->first();
            if ($storeProduct) {
                $storeProduct->quantity = $storeProduct->quantity + $request->quantity;
                $storeProduct->save();
            } else {
                StoreProduct::create([
                    'store_id' => $requestProduct->store_id,
                    'product_id' => $requestProduct->product_id,
                    'quantity' => $request->quantity,
                ]);
            }

            // update request product status
            $requestProduct->status = 'approved';
            $requestProduct->save();

            DB::commit();
            return response()->json(['message' => 'Permintaan berhasil di proses'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response(['message' => 'Permintaan barang berhasil diupdate'], 200);
    }
    // END WAREHOUSE
}
