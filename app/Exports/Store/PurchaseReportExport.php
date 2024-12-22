<?php

namespace App\Exports\Store;

use App\Models\ProductOut;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class PurchaseReportExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null) {
        $this->startDate = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : null;
    }

    public function view(): View
    {
        $purchases = Transaction::with('carts', 'carts.product')
            ->where('is_warehouse', 1)
            ->where('store_id', Auth::user()->store_id)
            ->orderBy('created_at', 'desc');
            
        if ($this->startDate !== null && $this->endDate !== null) {
            $purchases = $purchases->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $purchases = $purchases->get();
        return view('exports.store.purchase-report', compact('purchases'));
    }
}
