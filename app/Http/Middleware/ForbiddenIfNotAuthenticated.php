<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForbiddenIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (!Auth::guard($guard)->check()) {
                return response()->status(401);
            }
        }

        return $next($request);
    }
}
