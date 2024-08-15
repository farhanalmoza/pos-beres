<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('cashier.product.index');
    }

    public function requestStock(Request $request) {
        return view('cashier.product.request-stock');
    }
}
