<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-key');

        if (!$apiKey)
            return response()->json(['error' => 'Не передан API ключ'], 401);

        $storedKey = Storage::disk('local')->get('api_key');

        if (trim($storedKey) !== $apiKey)
            return response()->json(['error' => 'Неверный API ключ'], 401);

        return $next($request);
    }
}
