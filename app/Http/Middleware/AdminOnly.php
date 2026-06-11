<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('admin')->user();
        if (!$user || $user->role !== 'admin') {
            return redirect('/admin/login')->withErrors(['email' => 'You are not authorized.']);
        }
        return $next($request);
    }
} 