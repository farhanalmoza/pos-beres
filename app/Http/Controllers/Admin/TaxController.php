<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    public function index() {
        $tax = Tax::first();
        if (!$tax) {
            Tax::create([
                'tax' => 0,
            ]);
            $tax = Tax::first();
        }
        return view('admin.tax.index', compact('tax'));
    }

    public function updateTax(Request $request) {
        $request->validate([
            'tax' => 'required|numeric',
        ], [
            'tax.required' => 'Pajak wajib diisi',
            'tax.numeric' => 'Pajak harus berupa angka',
        ]);

        $tax = Tax::first();
        $tax->tax = $request->tax;
        $tax->save();
        return redirect()->route('admin.tax.index')->with('success', 'Pajak berhasil diubah');
    }
}
