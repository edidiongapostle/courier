<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $routeMiddleware = [
        'admin_only' => \App\Http\Middleware\AdminOnly::class,
        'not_blocked' => \App\Http\Middleware\NotBlocked::class,
    ];
} 