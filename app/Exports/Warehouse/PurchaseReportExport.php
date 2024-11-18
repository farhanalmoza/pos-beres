<?php

namespace App\Exports\Warehouse;

use App\Models\ProductIn;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PurchaseReportExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null) {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function view(): View {
        $results = ProductIn::with('product', 'supplier')->orderBy('created_at', 'desc');

        if ($this->startDate !== null && $this->endDate !== null) {
            $results = $results->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $results = $results->get();

        return view('exports.warehouse.purchase-report', ['purchases' => $results]);
    }
}
