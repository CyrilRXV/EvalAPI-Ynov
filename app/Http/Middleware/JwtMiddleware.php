<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $header = $request->header('Authorization');

        if (!$header || !preg_match('/Bearer\s(\S+)/', $header, $matches)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $token = $matches[1];

        try {
            $payload = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
            $user = User::query()->find($payload->sub);

            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // injection $user into the request
            $request->setUserResolver(fn() => $user);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
