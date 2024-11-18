<?php

namespace App\Exports\Warehouse;

use App\Models\ProductOut;
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
        $results = ProductOut::with('product', 'store')->orderBy('created_at', 'desc');

        if ($this->startDate !== null && $this->endDate !== null) {
            $results = $results->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $results = $results->get();

        return view('exports.warehouse.delivery-report', ['deliveries' => $results]);
    }
}
