<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Usuário ou senha inválidas'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Usuário deslogado com sucesso']);
    }

    public function refresh()
    {
        $token = auth('api')->refresh();

        return response()->json([
            'token' => $token
        ]);
    }


    public function me()
    {
        $user = User::where('id', auth()->user()->id)->first();

        if($user){
            return response()->json([
                'user' => $user
            ]);
        } else {
            return response()->json([
                'message' => 'Acesso não autorizado'
            ]);
        }

    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL()
        ]);
    }


}
