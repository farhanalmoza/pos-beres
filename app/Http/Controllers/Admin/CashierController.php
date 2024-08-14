<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index() {
        return view('admin.cashier.index');
    }

    public function create() {
        return view('admin.cashier.create');
    }

    public function edit() {
        return view('admin.cashier.edit');
    }
}
