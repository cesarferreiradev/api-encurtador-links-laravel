<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (Throwable $e) {
            $previous = $e->getPrevious();
            if ($previous instanceof ModelNotFoundException) {

                $fullModel = $previous->getModel();

                $model = str($fullModel)->afterLast('\\');

                return response()->json([
                    'errors' => $model . ' not found',
                    'status' => ResponseAlias::HTTP_NOT_FOUND
                ], ResponseAlias::HTTP_NOT_FOUND);
            }
        });
    })->create();
