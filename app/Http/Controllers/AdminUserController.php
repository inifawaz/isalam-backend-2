<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminUserItemResource;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        return response([
            'users' => AdminUserItemResource::collection(User::all())
        ]);
    }
}
