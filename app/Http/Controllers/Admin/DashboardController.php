<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductIn;
use App\Models\ProductOut;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index() {
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $data['expensesThisMonth'] = ProductIn::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('purchase_price');
        $salesThisMonth = ProductOut::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_price');
        $data['profitThisMonth'] = $salesThisMonth - $data['expensesThisMonth'];
        $data['topProducts'] = $this->getTopProducts();
        $data['inactiveProducts'] = $this->getInactiveProducts();
        $data['memberCount'] = Member::count();

        return view('admin.dashboard.index', compact('data'));
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

    public function getInactiveProducts() {
        // get date last 3 months
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        $inactiveProducts = Product::select('products.id', 'products.name', 'products.code')
            ->leftJoin('carts', 'carts.product_id', '=', 'products.id')
            ->leftJoin('transactions', function($join) use ($threeMonthsAgo) {
                $join->on('carts.no_invoice', '=', 'transactions.no_invoice')
                    ->where('transactions.created_at', '>=', $threeMonthsAgo);
            })
            ->where(function($query) {
                $query->whereNull('transactions.no_invoice')
                    ->orWhereDoesntHave('carts.transaction', function($query) {
                        $query->where('created_at', '>=', Carbon::now()->subMonths(3));
                    });
            })
            ->withCount(['carts as last_sold' => function($query) {
                $query->join('transactions', 'transactions.no_invoice', '=', 'carts.no_invoice')
                    ->select(DB::raw('MAX(transactions.created_at)'));
            }])
            ->groupBy('products.id', 'products.name', 'products.code')
            ->orderBy('last_sold', 'asc')
            ->take(5)
            ->get();
        
        $data = $inactiveProducts->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'last_sold_date' => $product->last_sold ? Carbon::parse($product->last_sold)->format('Y-m-d') : 'Tidak Terjual',
                'days_inactive' => $product->last_sold
                    ? Carbon::parse($product->last_sold)->diffInDays(Carbon::now())
                    : "Tidak Terjual",
            ];
        });

        return $data;
    }
}
