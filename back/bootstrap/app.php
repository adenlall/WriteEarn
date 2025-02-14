<?php /** @noinspection PhpInconsistentReturnPointsInspection */

use App\Http\Middleware\JsonRequestHeader;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(JsonRequestHeader::class);
        $middleware->priority([
            JsonRequestHeader::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(
            using: function (HttpExceptionInterface $e) {
                if (config('app.debug') !== true) {
                    if ($e->getStatusCode() === 403) {
                        return new JsonResponse([
                            'success' => false,
                            'message' => 'You don\'t have permission.',
                        ], 403);
                    }
                    return new JsonResponse([
                        'success' => false,
                        'message' => 'Internal Error',
                        'data' => null,
                    ], 500);
                }
            }
        );
    })->create();
