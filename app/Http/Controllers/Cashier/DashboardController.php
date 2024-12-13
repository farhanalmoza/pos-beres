<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\ProductOut;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $data['expensesThisMonth'] = ProductOut::where('store_id', Auth::user()->store_id)
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_price');
        $salesThisMonth = Transaction::where('store_id', Auth::user()->store_id)
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total');
        $data['profitThisMonth'] = $salesThisMonth - $data['expensesThisMonth'];
        $data['transactionsThisMonth'] = Transaction::where('store_id', Auth::user()->store_id)
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        return view('cashier.dashboard.index', compact('data'));
    }
}
