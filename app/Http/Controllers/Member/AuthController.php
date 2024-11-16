<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function loginForm() {
        return view('member.auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'phone' => 'required',
            'password' => 'required',
        ]);

        $member = Member::where('phone', $request->phone)->first();
        if (!$member) {
            return back()->withErrors(['phone' => 'Nomor WhatsApp belum terdaftar']);
        }

        // check password
        if (!Hash::check($request->password, Member::where('phone', $request->phone)->first()->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        Session::put('member', $member);
        return redirect()->route('member.dashboard');
    }
}
