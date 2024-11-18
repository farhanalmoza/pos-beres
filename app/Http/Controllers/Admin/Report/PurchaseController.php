<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use App\Models\ProductIn;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('admin.warehouse.report.purchase.index');
    }

    public function getAll() {
        $start_date = request('start_date');
        $end_date = request('end_date');
        
        $results = ProductIn::with('product', 'supplier')->orderBy('created_at', 'desc');

        if ($start_date !== null && $end_date !== null) {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);

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
}
