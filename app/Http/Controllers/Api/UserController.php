<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponse;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(5);
        return $this->successResponse($users, 'Fetched successfully');
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => 'user'
        ]);

        $token = $user->createToken($user->first_name . $user->last_name . 'AuthToken')->plainTextToken;
        return $this->successResponse([$user, 'access_token' => $token], __('main.register_customer_is_done'));
    }

    public function login(Request $request)

    {
        $input = $request->validate([
            'email' => 'required',
            'password' => 'required|'
        ]);

        $user = User::where('email', $input['email'])->first();
        if (!$user || !Hash::check($input['password'], $user->password)) {
            return $this->errorResponse('Invalid Credentials', 401);
        } else {
            $token = $user->createToken($user->first_name . $user->last_name . 'AuthToken')->plainTextToken;
            return $this->successResponse([$user, 'user_type' => $user->user_type, 'access_token' => $token], __('main.login_authenticated_is_done'));
        }
    }

    public function logout(Request $request)
    {

        Auth::user()->tokens()->delete();
        return $this->successResponse(null, __('main.log_out'));
    }
}
