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
            'webhooks/paymongo',
        ]);

        $middleware->alias([
            'seller' => \App\Http\Middleware\CheckIfSeller::class,
            'buyer' => \App\Http\Middleware\CheckIfBuyer::class,
            'admin' => \App\Http\Middleware\CheckIfAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'The uploaded file or payload exceeds the allowed size limit (maximum 64MB total). Please upload smaller files.',
                ], 413);
            }

            return redirect()->back()
                ->withInput($request->except(['id_photo', 'id_back_photo', 'id_selfie', 'proof_of_address', 'photos', 'avatar']))
                ->with('error', 'The uploaded file or photos exceed the upload limit. Please select smaller photos or files (under 25MB each).');
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, $request) {
            if ($e->getStatusCode() === 413) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'The request payload is too large (413 Content Too Large).',
                    ], 413);
                }

                return redirect()->back()
                    ->withInput($request->except(['id_photo', 'id_back_photo', 'id_selfie', 'proof_of_address', 'photos', 'avatar']))
                    ->with('error', 'The uploaded file or photos are too large (413 Content Too Large). Please upload smaller files or photos.');
            }
        });

        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->is('logout')) {
                return redirect('/')->with('info', 'You have been logged out.');
            }
            return redirect()->route('login')->with('info', 'Your session has expired. Please log in again.');
        });
    })->create();
