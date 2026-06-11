<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NotBlocked
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user() ?: auth('admin')->user();
        if ($user && $user->is_blocked) {
            auth()->logout();
            return redirect('/login')->withErrors(['email' => 'Your account is blocked.']);
        }
        return $next($request);
    }
} 