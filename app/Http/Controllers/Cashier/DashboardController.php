<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductOut;
use App\Models\StoreProduct;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $data['topProducts'] = $this->getTopProducts();
        $data['inactiveProducts'] = $this->getInactiveProducts();

        // dd($data['inactiveProducts']);

        return view('cashier.dashboard.index', compact('data'));
    }

    public function getTopProducts() {
        $topProducts = Cart::where('carts.store_id', Auth::user()->store_id)
            ->join('transactions', 'carts.no_invoice', '=', 'transactions.no_invoice')
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

        $inactiveProducts = StoreProduct::with('product')
            ->where('store_products.store_id', Auth::user()->store_id)
            ->leftJoin('products', 'store_products.product_id', '=', 'products.id')
            ->leftJoin('carts', 'carts.product_id', '=', 'store_products.product_id')
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
            ->select('products.id', 'products.name', 'products.code', 'store_products.product_id',
                DB::raw('(SELECT MAX(transactions.created_at) 
                    FROM carts 
                    JOIN transactions ON transactions.no_invoice = carts.no_invoice 
                    WHERE carts.product_id = store_products.product_id) as last_sold')
            )
            ->groupBy('products.id', 'products.name', 'products.code', 'store_products.product_id',)
            ->orderBy('last_sold', 'asc')
            ->take(5)
            ->get();

            return $inactiveProducts;
        
        $data = $inactiveProducts->map(function($StoreProduct) {
            return [
                'id' => $StoreProduct->product->id,
                'name' => $StoreProduct->product->name,
                'code' => $StoreProduct->product->code,
                'last_sold_date' => $StoreProduct->last_sold ? Carbon::parse($StoreProduct->last_sold)->format('Y-m-d') : 'Tidak Terjual',
                'days_inactive' => $StoreProduct->last_sold
                    ? Carbon::parse($StoreProduct->last_sold)->diffInDays(Carbon::now())
                    : "Tidak Terjual",
            ];
        });

        return $data;
    }
}
