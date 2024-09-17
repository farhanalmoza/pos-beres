<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RolePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan pengguna sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role dari pengguna
        $user = Auth::user();

        // Pastikan role pengguna memiliki permission
        if (!in_array($user->role, $roles)) {
            // jika admin, maka kembali ke dashboard admin
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // jika warehouse, maka kembali ke dashboard warehouse
            if ($user->role == 'warehouse') {
                return redirect()->route('warehouse.dashboard');
            }

            // jika cashier, maka kembali ke dashboard cashier
            if ($user->role == 'cashier') {
                return redirect()->route('cashier.dashboard');
            }
        }
        return $next($request);
    }
}
