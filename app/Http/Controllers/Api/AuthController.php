<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            $data['avatar'] = 'storage/' . $request->file('avatar')->store('avatars', 'public');
        } else {
            $data['avatar'] = asset('avatars/user-avatar.png');
        }        

        $user = User::create([
            'first_name'   => $data['first_name'],
            'last_name'    => $data['last_name'],
            'email'        => $data['email'],
            'phone_number' => $data['phone_number'],
            'password'     => $data['password'],
            'avatar'       => $data['avatar'],
            'user_type'    => 'user',
        ]);

        $user->access_token = $user->createToken("{$user->first_name}-{$user->id}-{$user->last_name}")->plainTextToken;

        return $this->successResponse(
            new UserResource($user),
            "User created successfully"
        );
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $user = User::where('email', $credentials['email'])->first();

        // Check if user not found
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return $this->errorResponse("Invalid credentials", 401);
        }

        // Create user token
        $user->access_token = $user->createToken("{$user->first_name}{$user->last_name}AuthToken")->plainTextToken;

        return $this->successResponse(
            new UserResource($user),
            "Logged in successfully"
        );
    }

    public function logout(Request $request)
    {
        // Check if user not authenticated
        if (!$request->user()) {
            return $this->errorResponse("Unauthenticated", 401);
        }

        // Delete user tokens
        Auth::user()->tokens()->delete();

        return $this->successResponse(null, "Logged out successfully");
    }
}
