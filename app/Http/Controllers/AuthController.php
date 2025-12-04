<?php

namespace App\Http\Controllers;

use App\Models\RefreshToken;
use App\Models\User;
use App\Service\JwtService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function __construct(
    private readonly JwtService $jwtService
){}

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::query()
            ->where('email','=', $request->email)
            ->first();
        if (! $credentials || ! Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
            $accessToken  = $this->jwtService->createAccessToken($user);
            $refreshToken = $this->jwtService->createRefreshToken($user);

            return response()->json([
                'access_token' => $accessToken,
                'token_type' => 'Bearer',
                'refresh_token' => $refreshToken,
                'message' => 'Successfully logged in',
            ]);
     }

    public function refresh(Request $request): JsonResponse
    {
        if (empty($request->cookie('refresh_token'))){
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }
        $request->merge([
            'refresh_token' => $request->cookie('refresh_token'),
        ]);

        $request->validate([
            'refresh_token' => 'required|string'
        ]);

        $hashedToken = hash('sha256', $request->refresh_token);

        $token = RefreshToken::query()
            ->where('token', $hashedToken)
            ->where('expires_at', '>', now())
            ->first();

        if (!$token) {
            return response()->json(['message' => 'Invalid refresh token'], 401);
        }

        /** @var User $user */
        $user = $token->user;
        $token->delete();

        $accessToken  = $this->jwtService->createAccessToken($user);
        $refreshToken = $this->jwtService->createRefreshToken($user);

        return response()->json([
            'access_token' => $accessToken,
            'token_type' => 'Bearer',
            'refresh_token' => $refreshToken,
            'message' => 'Refresh token successfully',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $request->user();
        $user->refreshTokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
