<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->withErrors(['error' => 'Please log in to continue.']);
        }

        if (!in_array(Auth::user()->role, ['admin', 'global_admin'])) {
            abort(403, 'Access denied. Unauthorized.');
        }

        return $next($request);
    }
}
