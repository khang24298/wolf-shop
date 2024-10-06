<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $authentication = $request->header('authorization')){
            return response()->json(['message' => 'Basic Auth not set'], 401);
        }
        $authentication = $request->header('authorization');
        $token = explode(' ',$authentication)[1];
        $decodeToken = base64_decode($token);
        $requestCredentials = explode(":",$decodeToken);

        // Hardcoded credentials (replace with your actual credentials)
        $expectedCredentials = ['your_email@example.com','your_password'];

        if ($requestCredentials !== $expectedCredentials) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $next($request);
    }
}
