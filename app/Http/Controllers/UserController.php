<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $create = User::create($request->validated());

        if ($create) {
            return $create->toResource();
        }

        return response()->json([
            'error' => true,
            'message' => "Erro ao cadastrar usuário"
        ], 500);
    }

    public function update(UpdateUserRequest $request)
    {
        $user = auth('sanctum')->user();
        $user->update($request->validated());

        return $user->toResource();
    }

    /**
     * Display the specified resource.
     * @throws \Throwable
     */
    public function me()
    {
        $user = auth('sanctum')->user();
        return $user->toResource();
    }
}
