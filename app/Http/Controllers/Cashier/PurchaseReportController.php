<?php

namespace App\Http\Controllers\Cashier;

use App\Exports\Store\PurchaseReportExport;
use App\Http\Controllers\Controller;
use App\Models\ProductOut;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseReportController extends Controller
{
    public function index()
    {
        return view('cashier.report.purchase.index');
    }

    public function getAll() {
        // get date
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        if ($start_date !== null && $end_date !== null) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();
        }


        $purchases = Transaction::with('carts', 'carts.product')
            ->where('is_warehouse', 1)
            ->where('store_id', Auth::user()->store_id)
            ->when($start_date !== null && $end_date !== null, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        $purchasedProducts = [];
        foreach ($purchases as $purchase) {
            foreach ($purchase->carts as $cart) {
                $purchasedProducts[] = $cart;
            }
        }
        
        return datatables()->of($purchasedProducts)
            ->addIndexColumn()
            ->addColumn('total', function($rows) {
                return $rows->quantity * $rows->price;
            })
            ->addColumn('date', function($rows) {
                return $rows->created_at->format('d-m-Y');
            })
            ->make(true);
    }

    public function export() {
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');
        $storeName = Auth::user()->store->name;

        $fileName = 'Laporan-Pembelian-'.$storeName.'.xlsx';
        if ($start_date != null && $end_date != null) {
            $fileName = 'Laporan-Pembelian-'.$storeName.'-'.$start_date.'-'.$end_date.'.xlsx';
        }
        
        return Excel::download(new PurchaseReportExport($start_date, $end_date),
            $fileName
        );
    }
}
