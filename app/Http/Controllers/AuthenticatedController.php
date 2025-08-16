<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            'status' => ResponseAlias::HTTP_UNAUTHORIZED,
            'message' => __('auth.failed')
        ], 401);
    }
}
