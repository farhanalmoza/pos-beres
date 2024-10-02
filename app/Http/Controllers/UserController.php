<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getWarehouse() {
        $results = User::select("id", "name", "no_telp", "email", "role")->where('role', 'warehouse')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('actions', function($rows) {
            // button ke halaman detail
            $btn = '<button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">Ubah</button>';
            $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function getCashier() {
        $results = User::select("id", "name", "no_telp", "email", "role", "store_id")->with('store')->where('role', 'cashier');
        $results = $results->orderBy('name', 'ASC')->get();
        return datatables()
        ->of($results)
        ->addIndexColumn()
        ->addColumn('actions', function($rows) {
            // button ke halaman detail
            $btn = '<button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">Ubah</button>';
            $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'">Hapus</button>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'role' => 'required|string|max:255',
        ]);

        // cek store_id
        if ($request->store_id) {
            $store = Store::find($request->store_id);
            if (!$store) {
                return response(['message' => 'Tidak ada toko yang ditemukan'], 400);
            }
            $store_id = $store->id;
        } else {
            $store_id = null;
        }

        $create = User::create([
            'name' => $request->name,
            'no_telp' => $request->no_telp,
            'email' => $request->email,
            'password' => Hash::make('password'),
            'role' => $request->role,
            'store_id' => $store_id,
        ]);
        
        if ($create) {
            return response(['message' => 'Akun berhasil dibuat'], 200);
        }
        return response(['message' => 'Gagal membuat akun'], 400);
    }

    public function show($id) {
        $user = User::findOrFail($id);
        if ($user) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $user,
            ]);
        }
        return response(['message' => 'Gagal menampilkan data pengguna'], 400);
    }

    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        if ($user) {
            // validation
            $this->validate($request, [
                'role' => 'required|string|max:255',
            ]);

            $user->role = $request->role;
            if ($user->role == 'cashier') {
                $user->store_id = $request->store_id;
            } else {
                $user->store_id = null;
            }
            $user->save();

            return response(['message' => 'Akun berhasil diubah'], 200);
        }
        return response(['message' => 'Gagal mengubah akun'], 400);
    }

    public function destroy($id) {
        $user = User::findOrFail($id);
        if(!$user) return response(['message' => 'terjadi kesalahan'], 500);
        $user->delete();
        return response(['message' => 'Hapus akun berhasil'], 200);
    }
}
