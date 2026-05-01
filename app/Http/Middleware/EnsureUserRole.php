<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserRole
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isSuperAdmin()) {
            return redirect('/superadmin');
        }

        return $next($request);
    }
}
