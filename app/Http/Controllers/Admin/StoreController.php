<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index() {
        if (Auth::user()->role == 'admin') {
            return view('admin.store.index');
        } else {
            return view('warehouse.store.index');
        }
    }

    public function getAll() {
        $results = Store::select("id", "name", "address")->orderBy('name', 'ASC')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('actions', function($rows) {
            // button ke halaman detail
            if (Auth::user()->role == 'admin') {
                $btn = '<a href="' . route('admin.store.detail', $rows->id) . '" class="btn btn-success btn-sm">Detail</a>';
                $btn .= ' <button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">Ubah</button>';
                $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'">Hapus</button>';
                return $btn;
            } else {
                $btn = '<a href="' . route('warehouse.store.detail', $rows->id) . '" class="btn btn-success btn-sm">Detail</a>';
            }
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores',
            'address' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama toko wajib diisi',
            'name.string' => 'Nama toko harus berupa string',
            'name.max' => 'Nama toko tidak boleh lebih dari 255 karakter',
            'name.unique' => 'Nama toko sudah ada',
            'address.required' => 'Alamat wajib diisi',
            'address.string' => 'Alamat harus berupa string',
            'address.max' => 'Alamat tidak boleh lebih dari 255 karakter',
        ]);

        $create = Store::create([
            'name' => $request->name,
            'address' => $request->address,
        ]);
        
        if ($create) {
            return response(['message' => 'Toko berhasil dibuat'], 200);
        }
        return response(['message' => 'Gagal membuat toko'], 400);
    }

    public function show($id) {
        $store = Store::find($id);
        
        if ($store) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $store,
            ]);
        }
    }

    public function detail($id) {
        $store = Store::find($id);
        
        if ($store) {
            if (Auth::user()->role == 'admin') {
                return view('admin.store.detail', compact('store'));
            } else {
                return view('warehouse.store.detail', compact('store'));
            }
        }
    }

    public function update(Request $request, $id) {
        $store = Store::find($id);
        
        if ($store) {
            // validation
            $this->validate($request, [
                'name' => 'required|string|max:255|unique:stores,name,'.$id,
                'address' => 'required|string|max:255',
            ]);

            $store->name = $request->name;
            $store->address = $request->address;
            $store->save();

            return response(['message' => 'Toko berhasil diubah'], 200);
        }
        return response(['message' => 'Gagal mengubah toko'], 400);
    }

    public function destroy($id) {
        $result = Store::findOrFail($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);
        $result->delete();
        return response(['message' => 'Hapus toko berhasil'], 200);
    }

    public function getStoreProducts($id) {
        $results = StoreProduct::select("product_id", "quantity")->where("store_id", $id)->with('product')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->rawColumns(['actions'])
        ->make(true);
    }
}
