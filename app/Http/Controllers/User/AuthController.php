<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\CredentialRequest;
use App\Libraries\Api\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param CredentialRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function register(CredentialRequest $request)
    {
        $credentials = $request->only(['email', 'name', 'password']);

        try {
            $user = User::create($credentials);
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                return (new Response(-1, "({$credentials['email']}) already exists.", null))->toJson();
            }
            throw $e;
        }

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    /**
     * @param CredentialRequest $request
     * @return JsonResponse
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
     * @return JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out.']);
    }

    /**
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * config('auth.passwords.users.expire', 60),
        ]);
    }
}
