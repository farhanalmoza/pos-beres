<?php

namespace App\Http\Controllers\Cashier;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function addTransactionForm() {
        $data['no_invoice'] = GenerateCode::invoice();
        return view('cashier.transaction.add', $data);
    }

    public function getCarts($no_invoice) {
        $results = Cart::where('no_invoice', $no_invoice)->with('product')->get();
        return response($results);
    }

    public function addToCart(Request $request) {
        $request->validate([
            'kode' => 'required',
            'no_invoice' => 'required',
        ]);

        $store_id = Auth::user()->store_id; // get store id
        $product = Product::where('code', $request->kode)->first(); // get product by code
        if (!$product) { // if product not found
            return response()->json([
                'message' => 'Barang tidak ditemukan',
            ], 404);
        }

        // check if product is in store
        $queryProduct = StoreProduct::with('product')->where('store_id', $store_id)
            ->where('product_id', $product->id)->first();
        
        if (!$queryProduct) { // if product not found in store
            return response()->json([
                'message' => 'Barang tidak tersedia di toko ini',
            ], 404);
        }

        // check product stock
        if ($queryProduct->quantity < 1) {
            return response()->json(['message' => 'Stok barang ini sudah habis',], 404);
        }

        // check if product already in cart
        $cart = Cart::where('no_invoice', $request->no_invoice)
            ->where('product_id', $product->id)->first();

        if ($cart) {
            if ($cart->quantity < $queryProduct->quantity) {
                $cart->update([
                    'quantity' => $cart->quantity + 1,
                ]);
            } else {
                return response()->json(['message' => 'Jumlah barang melebihi stok barang saat ini',], 404);
            }
        } else {
            Cart::create([
                'no_invoice' => $request->no_invoice,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'no_invoice' => $request->no_invoice,
        ]);
    }

    public function destroyCart($id) {
        $checkCart = Cart::findOrFail($id);
        if (!$checkCart) return response()->json(['message' => 'Data keranjang tidak ditemukan'], 404);
        $deleteCart = $checkCart->delete();
        if (!$deleteCart) return response()->json(['message' => 'Gagal menghapus data keranjang'], 404);
        return response()->json(['message' => 'Berhasil menghapus data keranjang']);
    }
}
