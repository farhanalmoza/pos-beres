<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\ProductOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseReportController extends Controller
{
    public function index()
    {
        return view('cashier.report.purchase.index');
    }

    public function getAll() {
        // get date
        $date = request()->input('date');
        if ($date != null) {
            return response()->json(['message' => $date]);
        } else {
            return response()->json(['message' => 'no date']);
        }


        $purchases = ProductOut::with('product')
            ->where('store_id', Auth::user()->store_id)
            ->get();
        
        return datatables()->of($purchases)
            ->addColumn('date', function($rows) {
                return $rows->created_at->format('d-m-Y');
            })
            ->make(true);
    }
}
