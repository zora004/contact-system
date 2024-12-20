<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard()
    {
        return view('auth.dashboard');
    }

    public function index()
    {
        return UserResource::collection(
            User::paginate(5)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        try {
            User::create([
                'name' => strtolower($request->name),
                'email' => strtolower($request->email),
                'contact_no' => strtolower($request->email),
                'company' => strtolower($request->company),
                'username' => strtolower($request->username),
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'User successfully created.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'No user found!'
            ], 400);
        }
        return $user;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'User successfully updated.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if (Auth::user()->id === $user->id) {
                return response()->json([
                    'status' => 'unauthorized',
                    'message' => 'Cannot delete own account.'
                ], 401);
            }
            $user->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'User successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function restore(User $user)
    {
        try {
            $user->restore();
            return response()->json([
                'status' => 'success',
                'message' => 'User successfully deleted.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function search(Request $request)
    {
        return UserResource::collection(
            User::where('name', 'like', '%' . $request->key . '%')
                ->orWhere('email', 'like', '%' . $request->key . '%')
                ->orWhere('contact_no', 'like', '%' . $request->key . '%')
                ->orWhere('company', 'like', '%' . $request->key . '%')
                ->orWhere('username', 'like', '%' . $request->key . '%')
                ->paginate(5)
        );
    }
}
