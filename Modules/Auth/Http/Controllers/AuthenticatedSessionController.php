<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Resources\UserResource;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {

        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credentials Not Matching'], 401);
        }
        if (Auth::guard('web')) {
            $request->authenticate();

            $request->session()->regenerate();

            return response()->json(['message' => 'User logged in successfully']);
        }

        return $this->respondWithToken($token);
    }

    public function apiStore(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Credentials Not Matching'], 401);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        $expiresAt = Carbon::now()->addMinutes(config('auth.token_expiration', 60));
        Auth::user()->tokens()->where('id', $token)->update(['expires_at' => $expiresAt]);
        return response()->json([
            'access_token' => Auth::user()->createToken('auth_token')->plainTextToken,
            'token_type' => 'bearer',
            'expires_in' => $expiresAt->diffInSeconds(Carbon::now()),
        ]);
    }

    public function apiDestroy(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json(['message' => 'User logged out successfully']);
    }

//    public function store(LoginRequest $request): \Illuminate\Http\JsonResponse
//    {
//        $request->authenticate();
//
//        $request->session()->regenerate();
//
//        return response()->json(['message' => 'User logged in successfully']);
//    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'User logged out successfully']);
    }

    public function getUser(Request $request)
    {
        $user = Auth::user();

        return new UserResource($user);
    }


}
