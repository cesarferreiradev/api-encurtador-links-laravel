<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthenticatedController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email', //:rfc,dns
            'password' => 'required|string',
            'remember_token' => 'boolean'
        ]);

        if (Auth::attempt($validated, ['remember_token' => false])) {

            $user = User::where('email', $validated['email'])->firstOrFail();

            if($user){
                $token = $user->createToken('auth-user')->plainTextToken;

                return response()->json([
                    'token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user,
                ]);
            }
        }

        return response()->json([
            'status'  => ResponseAlias::HTTP_UNAUTHORIZED,
            'code'    => 'unauthorized',
            'message' => __('auth.failed')
        ], 401);
    }

    function logout(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['status' => 'error', 'message' => 'Token not provided'], 400);
        }

        $access_token = PersonalAccessToken::findToken($token);

        if (!$access_token) {
            return response()->json([
                'status' => 'error',
                'message' => 'The provided token is invalid'
            ], 400);
        }

        $access_token->delete();

        return response()->json([
            'status' => ResponseAlias::HTTP_OK,
            'message' => 'Logout successful'
        ]);
    }
}
