<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SalesReportController extends Controller
{
    public function index() {
        return view('cashier.report.sale.index');
    }

    public function getAll() {
        $transactions = Transaction::with('carts.product')
            ->where('store_id', Auth::user()->store_id)
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
