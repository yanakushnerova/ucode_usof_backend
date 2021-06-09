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

        if ($token) {
            return ['token' => $token];
        } else {
            return response(['message' => 'Invalid data'], 400);
        }
    }
    
    public function registration(Request $request)
    {
        try {
            $this->validate($request, [
                'login' => 'required|unique:users|max:20',
                'username' => 'required|max:30',
                'email' => 'required|unique:users|regex:/(.*)@(gmail)\.com/i',
                'password' => 'required|max:20'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid format of data'], 400);
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
