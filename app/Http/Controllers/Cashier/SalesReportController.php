<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    public function index() {
        return view('cashier.report.sale.index');
    }

    public function getAll() {
        $start_date = request()->input('start_date');
        $end_date = request()->input('end_date');

        if ($start_date !== null && $end_date !== null) {
            $start_date = Carbon::parse($start_date)->startOfDay();
            $end_date = Carbon::parse($end_date)->endOfDay();
        }

        $transactions = Transaction::with('carts.product')
            ->where('store_id', Auth::user()->store_id)
            ->when($start_date !== null && $end_date !== null, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })
            ->get()
            ->flatMap(function ($transaction) {
                return $transaction->carts->map(function ($cart) use ($transaction) {
                    return [
                        'product_id' => $cart->product->id,
                        'product_name' => $cart->product->name,
                        'product_code' => $cart->product->code,
                        'product_category' => $cart->product->category->name,
                        'sold_quantity' => $cart->quantity,
                        'revenue' => $cart->quantity * ($cart->price - $cart->product_discount),
                        'remaining_stock' => $cart->product->quantity,
                    ];
                });
            });
        
        $groupSales = $transactions->groupBy('product_id')->map(function ($salesGroup) {
            return [
                'product_name' => $salesGroup->first()['product_name'],
                'product_code' => $salesGroup->first()['product_code'],
                'product_category' => $salesGroup->first()['product_category'],
                'sold_quantity' => $salesGroup->sum('sold_quantity'),
                'revenue' => $salesGroup->sum('revenue'),
                'remaining_stock' => $salesGroup->first()['remaining_stock'],
            ];
        });

        return datatables()->of($groupSales)->make(true);

        // return response()->json($groupSales);
    }
}
