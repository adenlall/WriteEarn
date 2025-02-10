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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\JsonRequestHeader::class);
        $middleware->priority([
            \App\Http\Middleware\JsonRequestHeader::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(
            using: function (\Symfony\Component\HttpKernel\Exception\HttpExceptionInterface $e) {
                if (config('app.debug') !== true) {
                    if ($e->getStatusCode() === 403) {
                        return new \Illuminate\Http\JsonResponse([
                            'success' => false,
                            'message' => 'You don\'t have permission.',
                        ], 403);
                    }
                    return new \Illuminate\Http\JsonResponse([
                        'success' => false,
                        'message' => 'Internal Error',
                        'data' => null,
                    ], 500);
                }
            }
        );
    })->create();
