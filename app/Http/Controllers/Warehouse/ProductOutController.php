<?php

namespace App\Http\Controllers\Warehouse;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductOut;
use App\Models\Store;
use App\Models\Tax;
use App\Models\Transaction;
use App\Notifications\WarehouseLowStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ProductOutController extends Controller
{
    public function sendProductForm() {
        $products = Product::where('quantity', '>', 0)->get();
        $noInvoice = GenerateCode::warehouseInvoice();
        $ppnPercentage = Tax::first()->tax;
        $stores = Store::all();
        return view('warehouse.product-out.add', compact('products', 'noInvoice', 'ppnPercentage', 'stores'));
    }

    public function addToCart(Request $request) {
        $request->validate([
            'product' => 'required',
            'quantity' => 'required|integer',
        ]);

        $product = Product::find($request->product);
        if (!$product) return response()->json(['message' => 'Data barang tidak ditemukan'], 404);

        // check product stock
        if ($product->quantity < $request->quantity) {
            return response()->json(['message' => 'Stok barang tidak cukup'], 400);
        }

        // check if product already in cart
        $cart = Cart::where('no_invoice', $request->noInvoice)
            ->where('product_id', $product->id)->first();

        if ($cart) return response()->json(['message' => 'Barang sudah ada dalam keranjang'], 400);

        Cart::create([
            'no_invoice' => $request->noInvoice,
            'is_warehouse' => true,
            'product_id' => $product->id,
            'user_id' => Auth::user()->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
        ]);

        return response()->json([
            'message' => 'Barang berhasil ditambahkan',
            'noInvoice' => $request->noInvoice,
        ]);
    }

    public function getCarts($noInvoice) {
        $results = Cart::with('product')
            ->where('no_invoice', $noInvoice)
            ->where('user_id', Auth::user()->id)
            ->get();
        return response($results);
    }

    public function deleteCart($id) {
        $cart = Cart::find($id);
        if ($cart) {
            $cart->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Barang telah dihapus'
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Barang tidak ditemukan'
        ]);
    }

    public function processSendProduct(Request $request) {
        $returnQtyProduct = false;
        $carts = Cart::where('no_invoice', $request['no_invoice'])->with('product')->get();
        if (!$carts) return response()->json(['message' => 'Keranjang masih kosong'], 422);

        $request->validate([
            'no_invoice' => 'required',
            'store_id' => 'required',
            'total_item' => 'required',
            'ppn' => 'required',
            'total' => 'required',
        ]);

        DB::beginTransaction();
        try {
            foreach ($carts as $cart) {
                // check if product is in store
                $product = Product::find($cart->product_id);
                    
                if ($product->quantity < $cart->quantity) {
                    $returnQtyProduct = true;
                } else {
                    // update product stock in store product
                    $product->quantity = $product->quantity - $cart->quantity;
                    $product->save();

                    // Send notification if stocks is low in store using Telegram
                    if ($product->quantity <= $product->low_stock) {
                        Notification::route('telegram', env('TELEGRAM_GROUP_STAFF_ID'))
                        ->notify(new WarehouseLowStock($product));
                    }
                }
            }

            if ($returnQtyProduct == false) {
                $createTransaction = Transaction::create([
                    'no_invoice' => $request['no_invoice'],
                    'is_warehouse' => true,
                    'store_id' => $request['store_id'],
                    'created_by' => Auth::user()->id,
                    'total_item' => $request['total_item'],
                    'ppn' => $request['ppn'],
                    'total' => $request['total'],
                    'cash' => 0,
                    'change' => 0,
                ]);

                if (!$createTransaction) return response()->json(['message' => 'Terjadi kesalahan'], 500);

                DB::commit();
                return response([
                    'message' => 'Barang siap dikirim',
                    'idTrx' => $createTransaction->id,
                    'change' => $createTransaction->change
                ], 200);
            } else {
                return response()->json(['message' => 'Terjadi kesalahan'], 422);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    // LIST PRODUCT OUT
    public function getProductOutList() {
        $results = Transaction::with('store')->where('is_warehouse', 1)->get();
        return datatables()
        ->of($results)
        ->addColumn('date', function ($item) {
            return $item->created_at->format('d-m-Y');
        })
        ->addColumn('actions', function ($item) {
            $btn = '<a href="'.route('warehouse.product-out.invoice', $item->no_invoice).'" class="btn btn-success btn-sm">Detail</a>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function invoiceView($invoice) {
        $productOut = Transaction::with('carts')->where('no_invoice', $invoice)->first();
        return view('warehouse/product-out/invoice', compact('productOut'));
    }
    // END LIST PRODUCT OUT
}
