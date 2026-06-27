<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        if ($request->user()->role !== $role) {
            if ($request->expectsJson()) {
                return response()->json(['message'=>'Akses ditolak'], 403);
            }
            abort(403, 'Akses ditolak');
        }

        return $next($request);
    }
}