<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(LoginUserRequest $request)
    {
        $request->validated($request->all());
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('API Token of ' . $request->username)->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Login success',
                'token' => $token,
            ], 200);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'The provided credentials do not match our records.',
        ], 400); // 400 is the HTTP status code for Bad Request
    }

    public function register(RegisterUserRequest $request)
    {
        $request->validated($request->all());

        User::create([
            'name' => strtolower($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
        ]);

        return UserResource::collection(
            User::all()
        );
    }

    public function logout(Request $request)
    {
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout success.',
        ], 200);
    }
}
