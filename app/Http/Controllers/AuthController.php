<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->full_name = $request->full_name;
        $user->phone_number = $request->phone_number;
        $user->email = $request->email;
        $user->province = $request->province ?? '';
        $user->city = $request->city ?? '';
        $user->district = $request->district ?? '';
        $user->village = $request->village ?? '';
        $user->zip_code = $request->zip_code ?? '';
        $user->address = $request->address ?? '';
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        if ($request->file('avatar_url')) {
            $file = $request->file('avatar_url');
            $filename = Str::slug($request->full_name, '_') . now()->format('Y_m_d_His') . "."  . $file->getClientOriginalExtension(); // TODO: berikan identifier unik menggunakat waktu saat ini
            $file->move(public_path('assets/img/users/avatar'), $filename);
            $user->avatar_url = asset('assets/img/users/avatar') . '/' . $filename;
        }
        $user->save();
        return response([
            'message' => 'berhasil merubah profile',
            'user' => new UserResource($user)
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
    public function registerAdmin(Request $request)
    {
        $user = User::create([
            'full_name' => $request->full_name,
            "phone_number" => $request->phone_number,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $user->assignRole('admin');
        return response([
            'user' =>  $user,
            "message" => 'berhasil menambah admin baru'
        ], 201);
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return response([
            'message' => 'berhasil menghapus pengguna'
        ]);
    }
}
