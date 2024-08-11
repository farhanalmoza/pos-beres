<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index() {
        return view('admin.member.index');
    }
    public function create() {
        return view('admin.member.create');
    }
    public function edit($id) {
        return view('admin.member.edit');
    }
}


