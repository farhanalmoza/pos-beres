<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index() {
        $stores = Store::all();
        return view('admin.warehouse.index', compact('stores'));
    }
}
