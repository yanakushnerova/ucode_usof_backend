<?php

namespace App\Http\Controllers;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $this->validate($request, [
            'login' => 'required|unique:users|max:20',
            'user name' => 'required',

            'body' => 'required',
        ]);

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
        JWTAuth::invalidate(JWTAuth::getToken());
        return response(['message' => 'Successfully logged out']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
