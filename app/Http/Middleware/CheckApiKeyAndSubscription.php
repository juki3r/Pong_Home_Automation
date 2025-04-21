<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckApiKeyAndSubscription
{
    public function handle(Request $request, Closure $next)
    {
        // Fetch the API key from the Authorization header (Bearer token)
        $apiKey = $request->bearerToken();

        if (!$apiKey) {
            return response()->json(['error' => 'API key missing'], 401);
        }

        $user = User::where('api_key', $apiKey)->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid API key'], 401);
        }

        if (!$user->subscribe) {
            return response()->json(['error' => 'Subscription required'], 403);
        }

        // Optionally pass the user to the request
        $request->merge(['auth_user' => $user]);

        return $next($request);
    }

}

