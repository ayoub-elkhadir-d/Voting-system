<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->user()->isSuperAdmin()) {
            return redirect('/dashboard');
        }

        return $next($request);
    }
}
