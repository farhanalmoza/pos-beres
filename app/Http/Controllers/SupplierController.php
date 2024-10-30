<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index() {
        return view('admin.supplier.index');
    }

    public function getAll() {
        $results = Supplier::select("id", "name", "person_responsible", "phone", "address")->get();
        return datatables()
        ->of($results)
        ->addColumn('actions', function($rows) {
            $btn = ' <button type="button" class="btn btn-primary btn-sm update" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$rows->id.'">ubah</button>';
            $btn .= ' <button type="button" class="btn btn-danger btn-sm delete" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="'.$rows->id.'">hapus</button>';
            return $btn;
        })
        ->rawColumns(['actions'])
        ->make(true);
    }

    public function store(Request $request) {
        $data = $request->all();
        $supplier = new Supplier();
        $supplier->name = $data['supplier_name'];
        $supplier->person_responsible = $data['person_responsible'];
        $supplier->phone = $data['phone'];
        $supplier->address = $data['address'];
        $supplier->save();
        return response(['message' => 'Supplier berhasil dibuat'], 200);
    }

    public function show($id) {
        $supplier = Supplier::find($id);
        
        if ($supplier) {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'data' => $supplier,
            ]);
        }
    }

    public function update(Request $request, $id) {
        $supplier = Supplier::find($id);
        
        if ($supplier) {
            $supplier->name = $request->supplier_name;
            $supplier->person_responsible = $request->person_responsible;
            $supplier->phone = $request->phone;
            $supplier->address = $request->address;
            $supplier->save();

            return response(['message' => 'Supplier berhasil diubah'], 200);
        }
        return response(['message' => 'Gagal mengubah supplier'], 400);
    }

    public function destroy($id) {
        $result = Supplier::findOrFail($id);
        if(!$result) return response(['message' => 'terjadi kesalahan'], 500);
        $result->delete();
        return response(['message' => 'Hapus supplier berhasil'], 200);
    }
}
