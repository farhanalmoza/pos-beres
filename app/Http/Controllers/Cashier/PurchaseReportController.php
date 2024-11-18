<?php

namespace App\Http\Controllers\Cashier;

use App\Exports\Store\PurchaseReportExport;
use App\Http\Controllers\Controller;
use App\Models\ProductOut;
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


        $purchases = ProductOut::with('product')
            ->where('store_id', Auth::user()->store_id)
            ->when($start_date !== null && $end_date !== null, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return datatables()->of($purchases)
            ->addColumn('product_code_name', function($product) {
                return $product->product->code . " - " . $product->product->name;
            })
            ->addColumn('date', function($rows) {
                return $rows->created_at->format('d-m-Y');
            })
            ->rawColumns(['product_code_name', 'date'])
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
