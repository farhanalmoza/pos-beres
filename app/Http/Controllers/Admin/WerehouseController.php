<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WerehouseController extends Controller
{
    public function index() {
        return view('admin.werehouse.index');
    }

    public function create() {
        return view('admin.werehouse.create');
    }

    public function edit() {
        return view('admin.werehouse.edit');
    }
}
