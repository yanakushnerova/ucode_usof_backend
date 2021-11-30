<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = request()->only(['login', 'password']);
        $token = JWTAuth::attempt($credentials);
        $user = JWTAuth::user();

        if ($token) {
            return ['token' => $token,
                'id' => $user['id'],
                'username' => $user['username'],
                'login' => $user['login'],
                'avatar' => $user['avatar'],
                'role' => $user['role']
            ];
        } else {
            return response(['message' => 'Invalid data'], 400);
        }
    }
    
    public function registration(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required|unique:users|max:20|min:3'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid login (must be shorter than 20 symbols and unique)'], 400);
        }

        try {
            $this->validate($request, [
                'username' => 'required|max:30|min:3'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid username (must be shorter than 30 symbols)'], 400);
        }

        try {
            $this->validate($request, [
                'email' => 'required|unique:users|regex:/(.*)@(gmail)\.com/i'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid email'], 400);
        }

        try {
            $this->validate($request, [
                'password' => 'required|max:20|min:5'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Password must contain 5-20 symbols'], 400);
        }

        $credentials = $request->all();

        if (!isset($credentials['login']) || !isset($credentials['username']) || !isset($credentials['email']) || !isset($credentials['password'])) {
            return response(['message' => 'Fill every field'], 400);
        }

        if ($credentials['password'] != $credentials['confirm_password']) {
            return response(['message' => 'Password wasn\'t confirmed'], 400);
        }

        $user = User::create([
            'login' => $request['login'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        return $user;
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response(['message' => 'Log out failed'], 401);
        }
    }


    // public function resetPassword(Request $request, $id)
    // {
    //     //
    // }
}
