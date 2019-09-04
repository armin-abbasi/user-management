<?php

namespace App\Http\Controllers;

use App\Http\Requests\CredentialRequest;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * @param CredentialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(CredentialRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        $user = User::create($credentials);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * @param CredentialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(CredentialRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Failed to authenticate.'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out.']);
    }

    /**
     * @param $token
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60
        ]);
    }
}
