<?php

namespace App\Http\Controllers\Cashier;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\ProductRequestCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRequestController extends Controller
{
    public function addView() {
        $requestNumber = GenerateCode::requestNumber();
        $products = Product::all();
        return view('cashier/product-request/add', compact('requestNumber', 'products'));
    }

    // CART
    public function getCarts($requestNumber) {
        $results = ProductRequestCart::with('product')
            ->where('request_number', $requestNumber)->get();
        return response($results);
    }

    public function addToCart(Request $request) {
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|integer',
        ]);

        $product = Product::find($request->product_id);
        if (!$product) return response()->json(['message' => 'Data barang tidak ditemukan'], 404);

        // check if product already in cart
        $cart = ProductRequestCart::where('request_number', $request->request_number)
            ->where('product_id', $product->id)->first();
        if ($cart) return response()->json(['message' => 'Barang sudah ada dalam permintaan'], 400);

        ProductRequestCart::create([
            'request_number' => $request->request_number,
            'product_id' => $product->id,
            'store_id' => Auth::user()->store_id,
            'user_id' => Auth::user()->id,
            'quantity' => $request->quantity,
        ]);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'noInvoice' => $request->request_number,
        ]);
    }

    public function deleteCart($id) {
        $cart = ProductRequestCart::find($id);
        if ($cart) {
            $cart->delete();
            return response()->json(['message' => 'Barang telah dihapus']);
        }
        return response()->json(['message' => 'Barang tidak ditemukan']);
    }
    // END CART

    public function storeProductRequest(Request $request) {
        $carts = ProductRequestCart::where('request_number', $request->request_number)->get();
        if (!$carts) return response()->json(['message' => 'Data masih kosong'], 422);

        $existingProductRequest = ProductRequest::where('request_number', $request->request_number)->first();
        if ($existingProductRequest) return response()->json(['message' => 'Permintaan barang sudah ada'], 422);

        $productRequest = ProductRequest::create([
            'request_number' => $request->request_number,
            'store_id' => Auth::user()->store_id,
            'created_by' => Auth::user()->id,
            'status' => 'requested',
        ]);

        if (!$productRequest) return response()->json(['message' => 'Gagal membuat permintaan barang'], 500);
        return response()->json(['message' => 'Permintaan barang berhasil dibuat']);
    }

    public function historyView() {
        return view('cashier/product-request/history');
    }
}
