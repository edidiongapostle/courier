<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // Middleware to prevent blocked users
    public function not_blocked(
        \Illuminate\Http\Request $request,
        \Closure $next
    ) {
        $user = auth()->user();
        if ($user && $user->is_blocked) {
            auth()->logout();
            return redirect('/login')->withErrors(['email' => 'Your account is blocked.']);
        }
        return $next($request);
    }

    // Middleware to restrict to admins only
    public function admin_only(
        \Illuminate\Http\Request $request,
        \Closure $next
    ) {
        $user = auth('admin')->user();
        if (!$user || $user->role !== 'admin') {
            return redirect('/admin/login')->withErrors(['email' => 'You are not authorized.']);
        }
        return $next($request);
    }
}
