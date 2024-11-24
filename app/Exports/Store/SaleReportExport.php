<?php

namespace App\Exports\Store;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class SaleReportExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null) {
        $this->startDate = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : null;
    }
    
    public function view(): View
    {
        $start_date = $this->startDate;
        $end_date = $this->endDate;

        $transactions = Transaction::with('carts.product', 'member')
            ->where('store_id', Auth::user()->store_id);

        if ($start_date !== null && $end_date !== null) {
            $transactions = $transactions->whereBetween('created_at', [$start_date, $end_date]);
        }
            
        $transactions = $transactions->get();

        $sales = [];
        foreach ($transactions as $trans) {
            foreach ($trans->carts as $cart) {
                $sales[] = [
                    'no_invoice' => $trans->no_invoice,
                    'product_name' => $cart->product->name,
                    'product_quantity' => $cart->product->quantity,
                    'product_price' => $cart->product->price,
                    'total' => $cart->product->quantity * $cart->product->price,
                    'member' => $trans->member !== null
                        ? $trans->member->name
                        : 'non member',
                    'date' => $trans->created_at->format('d-m-Y'),
                ];
            }
        }

        return view('exports.store.sale-report', compact('sales'));
    }
}
