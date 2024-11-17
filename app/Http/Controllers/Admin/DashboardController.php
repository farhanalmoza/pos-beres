<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $topProducts = $this->getTopProducts();

        return view('admin.dashboard.index', compact('topProducts'));
    }

    public function getTopProducts() {
        $topProducts = Cart::join('transactions', 'carts.no_invoice', '=', 'transactions.no_invoice')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->select('products.id',
                    'products.name',
                    'products.price',
                    'products.code',
                    DB::raw('SUM(carts.quantity) as total_sold')
            )
            ->whereMonth('transactions.created_at', Carbon::now()->month)
            ->whereYear('transactions.created_at', Carbon::now()->year)
            ->groupBy('products.id', 'products.name', 'products.price', 'products.code')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        return $topProducts;
    }
}
