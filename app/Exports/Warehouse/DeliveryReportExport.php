<?php

namespace App\Exports\Warehouse;

use App\Models\ProductOut;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DeliveryReportExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null) {
        $this->startDate = $startDate ? \Carbon\Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? \Carbon\Carbon::parse($endDate)->endOfDay() : null;
    }

    public function view(): View {
        $productOut = Transaction::with('carts', 'carts.product', 'store')
            ->where('is_warehouse', 1)
            ->orderBy('created_at', 'desc');

        if ($this->startDate !== null && $this->endDate !== null) {
            $productOut = $productOut->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $productOut = $productOut->get();
        $results = [];
        foreach ($productOut as $product) {
            foreach ($product->carts as $cart) {
                $cart['store'] = $product->store->name;
                $results[] = $cart;
            }
        }

        return view('exports.warehouse.delivery-report', ['deliveries' => $results]);
    }
}
