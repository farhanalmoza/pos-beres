<?php

namespace App\Http\Controllers\Cashier;

use App\Helpers\GenerateCode;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Product;
use App\Models\Store;
use App\Models\StoreProduct;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function addTransactionForm() {
        $data['no_invoice'] = GenerateCode::invoice();
        $members = Member::all();
        $data['members'] = $members;
        return view('cashier.transaction.add', $data);
    }

    public function getCarts($no_invoice) {
        $results = Cart::with('product')
            ->where('no_invoice', $no_invoice)
            ->where('user_id', Auth::user()->id)
            ->where('store_id', Auth::user()->store_id)
            ->get();
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
                'store_id' => $store_id,
                'user_id' => Auth::user()->id,
                'quantity' => 1,
                'price' => $product->price,
                'product_discount' => $product->discount,
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

    public function cancelTransaction($no_invoice) {
        $checkCart = Cart::where('no_invoice', $no_invoice)->count();
        if ($checkCart > 0) {
            $delete = Cart::where('no_invoice', $no_invoice)->delete();
            if (!$delete) return response()->json(['message' => 'Gagal membatalkan transaksi'], 500);
            return response()->json(['message' => 'Transaksi berhasil dibatalkan']);
        } else {
            return response()->json(['message' => 'Keranjang masih kosong'], 422);
        }
    }

    public function processPayment(Request $request) {
        $returnQtyProduct = false;
        $carts = Cart::where('no_invoice', $request['no_invoice'])->with('product')->get();
        if (!$carts) return response()->json(['message' => 'Keranjang masih kosong'], 422);

        DB::beginTransaction();
        try {
            foreach ($carts as $cart) {
                // check if product is in store
                $product = StoreProduct::where('store_id', $cart->store_id)
                    ->where('product_id', $cart->product_id)->first();
                    
                if ($product->quantity < $cart->quantity) {
                    $returnQtyProduct = true;
                } else {
                    // update product stock in store product
                    $product->quantity = $product->quantity - $cart->quantity;
                    $product->save();
                }
            }

            if ($returnQtyProduct == false) {
                $createTransaction = Transaction::create([
                    'no_invoice' => $request['no_invoice'],
                    'store_id' => $request['store_id'],
                    'created_by' => $request['created_by'],
                    'member_id' => $request['member_id'] ?? 0,
                    'transaction_discount' => $request['transaction_discount'],
                    'total' => $request['total'],
                    'cash' => $request['cash'],
                    'change' => $request['change'],
                    'notes' => $request['notes'],
                ]);

                if (!$createTransaction) return response()->json(['message' => 'Gagal membuat transaksi'], 500);

                DB::commit();
                return response([
                    'message' => 'Transaksi berhasil ditambahkan',
                    'idTrx' => $createTransaction->id,
                    'change' => $createTransaction->change
                ], 200);
            } else {
                return response(['message' => 'Transakasi gagal ditambahkan'], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // LIST TRANSACTIONS
    public function listTransactionsView() {
        return view('cashier.transaction.list');
    }

    public function listTransactions() {
        $results = Transaction::with('store', 'createdBy', 'member')
            ->where('store_id', Auth::user()->store_id)
            ->get();
            
        return datatables()
        ->of($results)
        ->addColumn('memberName', function($rows) {
            return $rows->member !== null
                ? '<span class="badge bg-success">'.substr($rows->member->name, 0, 10).'</span>'
                : '<span class="badge bg-warning">non member</span>';
        })
        ->addColumn('date', function($rows) {
            return $rows->created_at->format('d-m-Y');
        })
        ->addColumn('actions', function($rows) {
            $btn = '<a href="'.route('cashier.transaction.invoice', $rows->id).'" class="btn btn-primary btn-sm">Detail</a>';
            return $btn;
        })
        ->rawColumns(['actions', 'memberName'])
        ->make(true);
    }

    public function invoice($id) {
        $store = Store::find(Auth::user()->store_id);
        $invoice = Transaction::find($id);
        $items = Cart::with('product')
            ->where('no_invoice', $invoice->no_invoice)
            ->where('store_id', Auth::user()->store_id)
            ->get();
        return view('cashier.transaction.invoice', compact('invoice', 'store', 'items'));
    }

    public function downloadInvoice($id) {
        $store = Store::find(Auth::user()->store_id);
        $transactions = Transaction::with('carts')->find($id);
        // return view('exports.invoice', compact('store', 'transactions'));

        $pdf = PDF::loadView('exports.invoice', compact('store', 'transactions'));
        return $pdf->download($transactions->no_invoice.'.pdf');
    }
}
