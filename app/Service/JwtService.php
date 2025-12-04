<?php

namespace App\Service;

    use Firebase\JWT\JWT;
    use App\Models\User;
    use Illuminate\Support\Str;

    class JwtService
{
    public function createAccessToken(User $user): string
    {
        $payload = [
            'sub' => $user->id,
            'email' => $user->email,
            'role' => $user->role->value,
            'iat' => time(),
            'exp' => time() + 60*5,
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    function createRefreshToken(User $user): string
    {
        $token = Str::random(64);

        $user->refreshTokens()->create([
            'token' => hash('sha256', $token),
            'expires_at' => now()->addDays(30),
        ]);

        return $token;
    }
}
