<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function changePassword() {
        return view('member.setting.change-password');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required',
        ]);

        $member = Member::find(Session::get('member')->id);

        // check password
        if (!Hash::check($request->old_password, Session::get('member')->password)) {
            return back()->withErrors(['old_password' => 'Password lama salah']);
        }

        if ($request->password !== $request->password_confirmation) {
            return back()->withErrors(['password_confirmation' => 'Konfirmasi password salah']);
        }

        $member->password = Hash::make($request->password);
        $member->save();

        // update session
        Session::put('member', $member);

        return redirect()->back()->with('status', 'Password berhasil diubah');
    }

    public function editProfile() {
        $member = Member::find(Session::get('member')->id);
        return view('member.setting.edit-profile', compact('member'));
    }
}
