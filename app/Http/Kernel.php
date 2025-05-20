<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        // ...existing middleware...
    ];

    protected $middlewareGroups = [
        'web' => [
            // ...existing middleware...
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    protected $routeMiddleware = [
        // ...existing route middleware...
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ];
}