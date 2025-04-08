<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(5);
        return $this->success($users);
    }
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'user_type' => 'user'
        ]);

        $token = $user->createToken($user->name . 'AuthToken')->plainTextToken;
        return $this->success([$user, 'access_token' => $token], __('main.register_customer_is_done'));
    }

    public function login(Request $request)

    {
        $input = $request->validate([
            'email' => 'required',
            'password' => 'required|'
        ]);
        $user = User::where('email', $input['email'])->first();
        if (!$user || !Hash::check($input['password'], $user->password)) {

            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        } else {
            $token = $user->createToken($user->name . 'AuthToken')->plainTextToken;
            return $this->success([$user, 'user_type' => $user->user_type, 'access_token' => $token], __('main.login_authenticated_is_done'));
        }
    }

    public function logout(Request $request)
    {

        Auth::user()->tokens()->delete();
        return response()->json([
            "message" => __('main.log_out')
        ]);
    }
}
