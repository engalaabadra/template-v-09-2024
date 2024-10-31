<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Router;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        function (Router $router) {
            // Web routes
            $router->middleware('web')
                ->group(__DIR__.'/../routes/web.php');

            // API routes
            $router->middleware('api')
                ->prefix('api')
                ->name('api.')
                ->group(__DIR__.'/../routes/api.php');

            // Admin routes
            $router->middleware('api') // Use appropriate middleware, e.g., 'auth:api'
                ->prefix('api/admin')
                ->name('api.admin.')
                ->group(__DIR__.'/../routes/admin.php');
        },
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
            // Global middleware
            $middleware->trustProxies();
            // $middleware->handleCors();
            $middleware->preventRequestsDuringMaintenance();
            // $middleware->validatePostSize();
            $middleware->trimStrings();
            $middleware->convertEmptyStringsToNull();
            // $middleware->exceptionHandling();

            // Web middleware group
            $middleware->web(append: [
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
                \App\Http\Middleware\Localization::class,
            ]);

            // API middleware group
            $middleware->api(append: [
                \Laravel\Passport\Http\Middleware\CreateFreshApiToken::class,
                \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
                \Illuminate\Session\Middleware\StartSession::class,
                'throttle:api',
                \Illuminate\Routing\Middleware\SubstituteBindings::class,
            ]);        
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport(MissedFlightException::class);
 
        $exceptions->report(function (InvalidOrderException $e) {
            // ...
        });
    })->create();
