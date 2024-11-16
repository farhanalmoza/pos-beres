<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if member is authenticated
        if (Session::has('member')) {
            return redirect()->route('member.dashboard');
        }

        // Check if staff is authenticated
        if (Auth::check()) {
            return redirect()->route('login');
        }
        
        return $next($request);
    }
}
