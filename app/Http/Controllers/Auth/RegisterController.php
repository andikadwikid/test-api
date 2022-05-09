<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        // $request->only(['name', 'email', 'password']);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        // dd($user);
        $accessToken = $user->createToken('authToken')->accessToken;

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Error',
            ], 400);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Register success',
                'user' => $user,
                'access_token' => $accessToken,
            ], 200);
        }
    }
}
