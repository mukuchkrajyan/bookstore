<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class EnsureApiToken
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user && !$user->api_token) {
            $user->update([
                'api_token' => hash('sha256', Str::random(60))
            ]);
        }

        return $next($request);
    }
}
