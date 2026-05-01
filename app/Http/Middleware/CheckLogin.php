<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLogin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if (Auth::user()->is_banned) {
            Auth::logout();
            return redirect('/login')->withErrors(['email' => 'Your account has been banned.']);
        }

        return $next($request);
    }
}
