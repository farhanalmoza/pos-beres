<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchaseReportController extends Controller
{
    public function index() {
        return view('warehouse.report.purchase.index');
    }
}
