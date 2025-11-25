<?php

use App\Http\Middleware\AuthAdmin;
use App\Http\Middleware\AuthMember;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        $middleware->appendToGroup('authadmin', AuthAdmin::class);
        $middleware->appendToGroup('authmember', AuthMember::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
