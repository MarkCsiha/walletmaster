<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    //csak bizonyos host nevekre ad választ -> elfelejtett jelszó funkcióhoz szükséges
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustHosts(at: ['^laravel\.test$']);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
