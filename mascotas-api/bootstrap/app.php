<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (Illuminate\Database\Eloquent\ModelNotFoundException $e, $request) {
            return response()->json(['error' => 'Recurso no encontrado.'], 404);
        });

        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, $request) {
            return response()->json(['error' => 'Ruta no encontrada.'], 404);
        });

        $exceptions->render(function (Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json(['error' => 'No autenticado.'], 401);
        });

        $exceptions->render(function (Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, $request) {
            return response()->json(['error' => 'Acceso denegado.'], 403);
        });

        $exceptions->render(function (Illuminate\Validation\ValidationException $e, $request) {
            return response()->json([
                'message' => 'Errores de validación.',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (Throwable $e, $request) {
            return response()->json([
                'error' => 'Error interno del servidor.',
                'detalle' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        });
    })
    ->create();
