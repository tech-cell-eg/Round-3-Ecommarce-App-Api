<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CorsMiddleware;
use App\Http\Middleware\ForceJsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'is_admin' => AdminMiddleware::class
        ]);

        // This will add the ForceJsonResponse middleware to the beginning of the middleware stack
        $middleware->prepend(ForceJsonResponse::class);

        // This will add the CORS middleware to the end of the middleware stack
        $middleware->append(CorsMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'not found'
                ], 404);
            }
        });
        $exceptions->render(function (AccessDeniedHttpException $e, Request $request){
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'forbidden'
                ], 403);
            }
        });
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request){
            if ($request->is('api/*')) {
                return response()->json([
                    "message" => $e->getMessage(),
                ], 405);
            }
        });
    })->create();
