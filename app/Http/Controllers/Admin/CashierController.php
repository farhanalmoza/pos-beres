<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index() {
        $stores = Store::all();
        return view('admin.cashier.index', compact('stores'));
    }
}
