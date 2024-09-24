<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function index() {
        $categories = ProductCategory::paginate(10);
        return view('admin.product-category.index', compact('categories'));
    }

    public function getAll() {
        $results = ProductCategory::select("id", "name")->orderBy('id', 'DESC')->get();
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
        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories',
        ], [
            'name.required' => 'Kategori barang wajib diisi',
            'name.string' => 'Kategori barang harus berupa string',
            'name.max' => 'Kategori barang tidak boleh lebih dari 255 karakter',
            'name.unique' => 'Kategori barang sudah ada',
        ]);

       $create = ProductCategory::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        
        if ($create) {
            return redirect()->route('admin.product-category.index')->with('success', 'Kategori barang berhasil dibuat');
        }

        return redirect()->back()->with('error', 'Gagal membuat kategori barang');
    }

    public function show ($id) {
        $category = ProductCategory::find($id);
        
        if ($category) {
            // return json with code without view
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $category,
            ]);
        }
    }

    public function update(Request $request, $id) {
        $category = ProductCategory::find($id);
        
        if ($category) {
            // validation
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:product_categories,name,'.$id,
            ], [
                'name.required' => 'Kategori barang wajib diisi',
                'name.string' => 'Kategori barang harus berupa string',
                'name.max' => 'Kategori barang tidak boleh lebih dari 255 karakter',
                'name.unique' => 'Kategori barang sudah ada',
            ]);

            // jika update_name adalah nama yang sama, maka tidak perlu update
            if ($category->name == $request->update_name) {
                return redirect()->back()->with('error', 'Nama kategori barang tidak boleh sama dengan yang sudah ada');
            }

            // jika update_name sudah ada, maka berikan pesan error
            if (ProductCategory::where('name', $request->update_name)->first()) {
                return response(['message' => 'Kategori barang sudah ada'], 400);
            }

            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->save();

            return response(['message' => 'Kategori barang berhasil diubah'], 200);
        }

        return response(['message' => 'Gagal mengubah kategori barang'], 400);
    }

    public function destroy($id) {
        $result = ProductCategory::findOrFail($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);
        $result->delete();
        return response(['message' => 'Hapus kategori barang berhasil'], 200);
    }
}
