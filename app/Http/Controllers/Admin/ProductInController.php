<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductInController extends Controller
{
    public function index() {
        $suppliers = Supplier::all();
        $products = Product::all();

        if (Auth::user()->role == 'admin') {
            return view('admin.product-in.index', compact('products', 'suppliers'));
        } else {
            return view('warehouse.product-in.index', compact('products', 'suppliers'));
        }
    }

    public function getAll() {
        $results = ProductIn::with(['product', 'supplier']);
        $results = $results->orderBy('created_at', 'desc')->get();
        return datatables()
        ->of($results)
        ->addColumn('supplier', function($rows) {
            return $rows->supplier->name ?? '-';
        })
        ->addColumn('total', function($rows) {
            return $rows->quantity * $rows->purchase_price;
        })
        ->addColumn('date_in', function($rows) {
            return $rows->created_at->format('d-m-Y');
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'supplier_id' => 'required|integer',
            'product_id' => 'required|integer',
            'purchase_price' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        DB::beginTransaction();
        try {
            ProductIn::create([
                'supplier_id' => $request->supplier_id,
                'product_id' => $request->product_id,
                'purchase_price' => $request->purchase_price,
                'quantity' => $request->quantity,
            ]);

            $product = Product::find($request->product_id);
            $product->quantity = $product->quantity + $request->quantity;
            $product->save();
            DB::commit();
            return response(['message' => 'Barang masuk berhasil ditambah'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => 'Barang masuk gagal ditambah'], 400);
        }
        DB::commit();
    }
}
