<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');
        if ($apiKey !== env('API_KEY', 'your-api-key-here')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
                'code' => 401
            ], 401);
        }
        return $next($request);
    }
}