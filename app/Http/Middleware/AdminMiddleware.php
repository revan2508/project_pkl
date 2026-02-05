<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
         if ($request->routeIs('*') && (Auth::check() && Auth::user()->is_admin !== 1)) {
         abort(403, 'Akses di Tolak.');
    }
        return $next($request);
    }
}