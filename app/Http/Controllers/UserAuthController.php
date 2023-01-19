<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{

    public function getLogin()
    {
        return view("login");
    }

    public function getRegister()
    {
        return view("register");
    }

    public function registerHandler(Request $request)
    {
        $request->validate([
            "name" => "required|max:125",
            "email" => "required|email|unique:users",
            "password" => "required"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
        $token = $user->createToken("Access Token");
        return response()->json([
            "message" => "User registered successfully",
            "user" => $user,
            "token" => $token
        ]);
    }

    public function loginHandler(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required|string|max:125"
        ]);
        $user = User::find(2);
        Auth::login($user);
        return redirect('/');
        
    }
}
