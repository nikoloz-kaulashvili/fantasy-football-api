<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ApiAccessLogger
{
    public function handle(Request $request, Closure $next): Response
    {
        $requestId = $request->header('X-Request-Id') ?? (string) Str::uuid();
        $request->attributes->set('request_id', $requestId);
        $start = microtime(true);
        $response = $next($request);
        $duration = round((microtime(true) - $start) * 1000, 2);
        $status   = $response->getStatusCode();

        $logData = [
            'request_id' => $requestId,
            'method'     => $request->method(),
            'path'       => $request->path(),
            'user_id'    => optional($request->user())->id,
            'ip'         => $request->ip(),
            'status'     => $status,
            'duration_ms' => $duration,
        ];

        if ($status >= 400) {
            Log::channel('api_error')->warning('API_FAILED', $logData);
        }

        else {
            Log::channel('api_access')->info('API_SUCCESS', $logData);
        }

        $response->headers->set('X-Request-Id', $requestId);

        return $response;
    }
}
