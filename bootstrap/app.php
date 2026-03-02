<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->appendToGroup('api', [
            \App\Http\Middleware\SetLocaleFromHeader::class,
            \App\Http\Middleware\ApiAccessLogger::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $e) {

            $request = request();

            Log::channel('api_error')->error('API_EXCEPTION', [
                'request_id' => $request->attributes->get('request_id'),
                'message' => $e->getMessage(),
                'type' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => auth()->id(),
                'url' => $request->fullUrl(),
                'method' => $request->method(),
            ]);
        });
    })->create();
