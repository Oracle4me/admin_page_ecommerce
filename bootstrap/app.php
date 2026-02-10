<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Providers\ModuleRouteProvider;
use App\Providers\ModuleServiceProvider;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->prepend(\Illuminate\Http\Middleware\HandleCors::class);

        // Web Route Middleware
        $middleware->web(prepend: [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class, 
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class
        ]);


        $middleware->alias([
            'jwt.auth' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class,
            'role' => \App\Http\Middleware\AuthMiddleware::class,
        ]);
    })

    ->withProviders([
        ModuleRouteProvider::class,
    ])

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
