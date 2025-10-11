<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Encrypt cookies, excluding some keys
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        // Alias your custom middleware
        $middleware->alias([
            'NoCache' => App\Http\Middleware\NoCache::class,
        ]);

        // Append middleware to the web group
        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
            App\Http\Middleware\NoCache::class, // <-- add this
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

  
