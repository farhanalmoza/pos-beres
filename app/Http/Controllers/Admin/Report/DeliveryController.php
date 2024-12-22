<?php

namespace App\Http\Controllers\Admin\Report;

use App\Exports\Warehouse\DeliveryReportExport;
use App\Http\Controllers\Controller;
use App\Models\ProductOut;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            return view('admin.warehouse.report.delivery.index');
        } else {
            return view('warehouse.report.delivery.index');
        }
    }

    public function getAll() {
        // get date
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');
        
        $productOut = Transaction::with('carts', 'carts.product', 'store')
            ->where('is_warehouse', 1)
            ->orderBy('created_at', 'desc');

        if ($start_date !== null && $end_date !== null) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();

            $productOut = $productOut->whereBetween('created_at', [$start_date, $end_date]);
        }

        $productOut = $productOut->get();
        $results = [];
        foreach ($productOut as $product) {
            foreach ($product->carts as $cart) {
                $cart['store'] = $product->store->name;
                $results[] = $cart;
            }
        }

        return datatables()
            ->of($results)
            ->addIndexColumn()
            ->addColumn('total', function($row) {
                return $row->quantity * $row->price;
            })
            ->addColumn('created_at', function($product) {
                return $product->created_at->format('Y-m-d');
            })
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
