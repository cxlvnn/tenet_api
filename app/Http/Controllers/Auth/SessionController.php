<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;

class SessionController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());
        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'email' => $user->email,
            'token' => $token,
        ];
    }
}
