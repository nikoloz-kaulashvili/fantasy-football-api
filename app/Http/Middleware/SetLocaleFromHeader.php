<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language', 'gb');

        $map = [
            'gb' => 'en',
            'ge' => 'ka',
        ];

        $locale = $map[$locale] ?? 'en';

        app()->setLocale($locale);

        return $next($request);
    }
}
