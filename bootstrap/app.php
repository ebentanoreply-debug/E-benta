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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');

        $middleware->validateCsrfTokens(except: [
            '/logout',
            'logout',
        ]);

        $middleware->alias([
            'seller' => \App\Http\Middleware\CheckIfSeller::class,
            'buyer' => \App\Http\Middleware\CheckIfBuyer::class,
            'admin' => \App\Http\Middleware\CheckIfAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->is('logout')) {
                return redirect('/')->with('info', 'You have been logged out.');
            }
            return redirect()->route('login')->with('info', 'Your session has expired. Please log in again.');
        });
    })->create();
