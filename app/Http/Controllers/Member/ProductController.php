<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        return view('member.product.index');
    }

    public function getAll() {
        $results = Product::get();
        return datatables()
        ->of($results)
        ->make(true);
    }
}
