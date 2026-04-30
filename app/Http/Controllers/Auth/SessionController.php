<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->safe()->only('name', 'email', 'password'));
        $company = new Company();
        $company->name = $request->companyName;
        $company->user_id = $user->id;
        $company->save();
        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'email' => $user->email,
            'company' => new CompanyResource($company),
            'token' => $token,
        ];
    }

    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt($request->validated())) {
            $token = Auth::user()->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful!',
                'token' => $token,
            ], 200);
        }

        return response()->json(['message' => 'Wrong credentials'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully!',
        ], 200);
    }
}
