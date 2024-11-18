<?php

namespace App\Http\Controllers\Admin\Report;

use App\Exports\Warehouse\DeliveryReportExport;
use App\Http\Controllers\Controller;
use App\Models\ProductOut;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryController extends Controller
{
    public function index()
    {
        return view('admin.warehouse.report.delivery.index');
    }

    public function getAll() {
        // get date
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');
        
        $results = ProductOut::with('product', 'store')->orderBy('created_at', 'desc');

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
            ->addColumn('created_at', function($product) {
                return $product->created_at->format('Y-m-d');
            })
            ->rawColumns(['product_code_name', 'created_at'])
            ->make(true);
    }

    public function export() {
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        $fileName = 'Laporan-Pengiriman.xlsx';
        if ($start_date != null && $end_date != null) {
            $fileName = 'Laporan-Pengiriman-'.$start_date.'-'.$end_date.'.xlsx';
        }
        
        return Excel::download(new DeliveryReportExport($start_date, $end_date),
            $fileName
        );
    }
}
