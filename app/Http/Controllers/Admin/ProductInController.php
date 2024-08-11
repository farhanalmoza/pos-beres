<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductInController extends Controller
{
    public function index() {
        return view('admin.product-in.index');
    }

    public function create() {
        return view('admin.product-in.create');
    }

    public function edit($id) {
        return view('admin.product-in.edit');
    }
}
