<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response([
                'message' => 'email atau password anda salah'
            ], 401);
        }

        return response([
            'user' => new UserResource(auth()->user()),
            'token' => Auth::user()->createToken('token')->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        /** @var User $user */
        Auth::user()->tokens()->delete();
        return response([
            'message' => 'anda berhasil logout'
        ]);
    }

    public function me(Request $request)
    {
        return response([
            'user' => new UserResource(Auth::user())
        ]);
    }

    public function register(Request $request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $user->assignRole('user');
        return response([
            'user' =>  $user,
            'token' => $user->createToken('token')->plainTextToken
        ], 201);
    }
}
