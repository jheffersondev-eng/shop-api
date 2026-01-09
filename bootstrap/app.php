<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../src/Api/routes/web.php',
        api: __DIR__.'/../src/Api/routes/api.php',
        commands: __DIR__.'/../src/Api/routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            // middleware padrão de API (stateless)
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage() ?: 'Erro interno do servidor',
                ], 500);
            }
        });
    })->create();

// Set the application path to src directory to match the Src namespace
$app->useAppPath($app->basePath('src'));

return $app;
