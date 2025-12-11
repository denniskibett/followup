<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * Global HTTP middleware stack.
     * These run during every request to your application.
     */
    protected $middleware = [
        \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        

        // Your custom global middleware
        \App\Http\Middleware\ApplySystemSettings::class,
    ];

    
    /**
     * Middleware Groups
     */
    protected $middlewareGroups = [

        'web' => [
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,   // CSRF only applied to web routes
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            // Optional middlewares
            \App\Http\Middleware\SetUserTimezone::class,
            \App\Http\Middleware\RecordUserActivity::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // Add only if needed
            // \App\Http\Middleware\CheckMaintenanceMode::class,
            // \App\Http\Middleware\LogRequests::class,
        ],
    ];


    /**
     * Route Middleware
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
        'role' => \App\Http\Middleware\EnsureRole::class,
        'maintenance' => \App\Http\Middleware\CheckMaintenanceMode::class,
        
    ];
}
