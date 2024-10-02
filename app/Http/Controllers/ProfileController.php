<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editPassword() {
        return view('profile.edit-password');
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        /** @var \App\Models\User $user **/
        $user = Auth::user();
        
        // cek password lama
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('profile.edit-password')->with('status', 'Password lama salah');
        }

        // update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.edit-password')->with('status', 'Password berhasil diubah');
    }

    public function editProfile() {
        $user = Auth::user();
        return view('profile.edit-profile', compact('user'));
    }

    public function updateNoTelp(Request $request) {
        $request->validate([
            'no_telp' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        /** @var \App\Models\User $user **/
        $user = Auth::user();

        // cek password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('profile.edit-profile')->with('status', 'Password salah');
        }

        // update no telepon
        $user->no_telp = $request->no_telp;
        $user->save();

        return redirect()->route('profile.edit-profile')->with('status', 'No telepon berhasil diubah');
    }
}
