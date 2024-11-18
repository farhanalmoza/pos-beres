<?php

namespace App\Http\Controllers\Admin\Report;

use App\Exports\Warehouse\PurchaseReportExport;
use App\Http\Controllers\Controller;
use App\Models\ProductIn;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PurchaseController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin.warehouse.report.purchase.index');
        } else {
            return view('warehouse.report.purchase.index');
        }
    }

    public function getAll() {
        $start_date = request('start_date');
        $end_date = request('end_date');
        
        $results = ProductIn::with('product', 'supplier')->orderBy('created_at', 'desc');

        if ($start_date !== null && $end_date !== null) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();

            $results = $results->whereBetween('created_at', [$start_date, $end_date]);
        }

        $results = $results->get();

        return datatables()
            ->of($results)
            ->addColumn('product_code_name', function($product) {
                return $product->product->code . " - " . $product->product->name;
            })
            ->addColumn('total', function($product) {
                return $product->product->price * $product->quantity;
            })
            ->addColumn('created_at', function($product) {
                return $product->created_at->format('Y-m-d');
            })
            ->rawColumns(['product_code_name', 'total', 'created_at'])
            ->make(true);
    }

    public function export() {
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        $fileName = 'Laporan-Pembelian.xlsx';
        if ($start_date != null && $end_date != null) {
            $fileName = 'Laporan-Pembelian-'.$start_date.'-'.$end_date.'.xlsx';
        }
        
        return Excel::download(new PurchaseReportExport($start_date, $end_date),
            $fileName
        );
    }
}
