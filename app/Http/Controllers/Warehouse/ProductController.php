<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('warehouse.product.index');
    }

    public function productIn() {
        return view('warehouse.product-in.index');
    }

    public function productOut() {
        return view('warehouse.product-out.index');
    }
}
