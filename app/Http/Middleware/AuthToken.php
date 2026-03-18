<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class AuthToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token || !$user = User::where('api_token', $token)->first()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Set authenticated user for the current request (API context)
        auth()->setUser($user);

        return $next($request);
    }
}