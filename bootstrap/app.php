<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Alias middleware yang dipakai di routes/web.php
        $middleware->alias([
            // 'auth' = pemeriksa sesi login CleanHub (sesi: is_login). 'login' dipertahankan agar route lama tetap jalan.
            'auth'  => \App\Http\Middleware\EnsureLoggedIn::class,
            'login' => \App\Http\Middleware\EnsureLoggedIn::class,
            'role'  => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
