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

        $transactions = Transaction::with('carts.product', 'member')
            ->where('store_id', Auth::user()->store_id)
            ->when($start_date !== null && $end_date !== null, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('created_at', [$start_date, $end_date]);
            })->get();
        
        $results = [];
        foreach ($transactions as $trans) {
            foreach ($trans->carts as $cart) {
                $results[] = [
                    'no_invoice' => $trans->no_invoice,
                    'product_name' => $cart->product->name,
                    'product_quantity' => $cart->product->quantity,
                    'product_price' => $cart->product->price,
                    'total' => $cart->product->quantity * $cart->product->price,
                    'member' => $trans->member !== null
                        ? substr($trans->member->name, 0, 12)
                        : 'non member',
                    'date' => $trans->created_at->format('d-m-Y'),
                ];
            }
        }

        return datatables()->of($results)->make(true);

        // return response()->json($results);
    }
}
