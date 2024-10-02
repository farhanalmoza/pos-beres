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
        $results = Product::select("id", "code", "name", "category_id", "quantity", "price")->with('category')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('actions', function($rows) {
            $btn = '<button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">Ubah</button>';
            $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['actions'])
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
        ]);

        $create = Product::create([
            'code' => $request->code,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'price' => $request->price,
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
            ]);

            $product->code = $request->code;
            $product->name = $request->name;
            $product->slug = Str::slug($request->name);
            $product->category_id = $request->category_id;
            $product->price = $request->price;
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
}
