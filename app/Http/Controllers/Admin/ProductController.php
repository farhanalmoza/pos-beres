<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index() {
        $categories = ProductCategory::get();
        if (Auth::user()->role == 'warehouse') {
            return view('warehouse.product.index', compact('categories'));
        } else {
            return view('admin.product.index', compact('categories'));
        }
    }

    public function getAll() {
        $results = Product::with('category')->get();
        return datatables()
        ->of($results)
        ->addColumn('product_name', function($rows) {
            if (strlen($rows->name) > 15) {
                return substr($rows->name, 0, 15).'...';
            } else {
                return $rows->name;
            }
        })
        ->addColumn('actions', function($rows) {
            $btn = '<button type="button" class="btn btn-success btn-sm detail" data-id="'.$rows->id.'">
                        <i class="bx bxs-show" style="font-size: 15px;"></i>
                    </button>'; 
            $btn .= ' <button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">
                        <i class="bx bx-edit-alt" style="font-size: 15px;"></i>
                    </button>';
            $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'">
                        <i class="bx bx-trash" style="font-size: 15px;"></i>
                    </button>';
            return $btn;
        })
        ->rawColumns(['actions', 'product_name'])
        ->make(true);
    }

    public function store(Request $request) {
        // cek kode barang sudah ada
        if (Product::where('code', $request->code)->first()) {
            return response(['message' => 'Kode barang sudah ada'], 400);
        }
        // cek nama barang sudah ada
        if (Product::where('name', $request->name)->first()) {
            return response(['message' => 'Nama barang sudah ada'], 400);
        }

        $request->validate([
            'code' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price' => 'required|integer',
            'warehouse_price' => 'required|integer',
            'low_stock' => 'required|integer',
        ]);

        $create = Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'price' => $request->price,
            'warehouse_price' => $request->warehouse_price,
            'low_stock' => $request->low_stock,
        ]);
        
        if ($create) {
            return response(['message' => 'Barang berhasil dibuat'], 200);
        }
        return response(['message' => 'Gagal membuat barang'], 400);
    }

    public function show ($id) {
        $product = Product::find($id);
        
        if ($product) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $product,
            ]);
        }
    }

    public function update(Request $request, $id) {
        $product = Product::find($id);
        
        if ($product) {
            // validation
            $this->validate($request, [
                'code' => 'required|string|max:255|unique:products,code,'.$id,
                'name' => 'required|string|max:255',
                'category_id' => 'required|integer',
                'price' => 'required|integer',
                'warehouse_price' => 'required|integer',
                'low_stock' => 'required|integer',
            ]);

            $product->code = $request->code;
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->price = $request->price;
            $product->warehouse_price = $request->warehouse_price;
            $product->low_stock = $request->low_stock;
            $product->save();

            return response(['message' => 'Barang berhasil diubah'], 200);
        }
        return response(['message' => 'Gagal mengubah barang'], 400);
    }

    public function destroy($id) {
        $result = Product::findOrFail($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);
        $result->delete();
        return response(['message' => 'Hapus barang berhasil'], 200);
    }

    public function getWarehouseProductPrice($id) {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Barang tidak ditemukan'], 404);
        } else {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $product->warehouse_price,
            ]);
        }
    }
}
