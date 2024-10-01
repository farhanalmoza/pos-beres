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
}
