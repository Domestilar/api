<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);
        if (!$token = auth('users')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized', 'status' => false], 401);
        }

        return $this->respondWithToken($token, $request->email);
    }

    protected function respondWithToken($token, $email)
    {
        $user = User::where('email', $email)->first();
        $user->token = $token;
        return response()->json([
            "status" => true,
            'user' => $user,
            'token_type' => 'bearer',
            'expires_in' => auth('users')->factory()->getTTL()
        ]);
    }
}
