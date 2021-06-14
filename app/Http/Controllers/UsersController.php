<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isUser = JWTAuth::user();
        
        if (!$isUser) {
            return response(['message' => 'Token required'], 400);
        }
        
        if ($isUser['role'] != 'admin') {
            return response(['message' => 'Forbidden action'], 403);
        } else {
            $user = User::create([
                'login' => $request['login'],
                'username' => $request['username'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);
    
            return $user;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (User::find($id) == null) {
            return response(['message' => 'User does not exist'], 404);
        } else {
            return User::find($id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $isUser = JWTAuth::user();
        
        if (!$isUser) {
            return response(['message' => 'Token required'], 400);
        }

        if (User::find($id) == null) {
            return response(['message' => 'User does not exist'], 404);
        } else if ($isUser->id != $id) {
            return response(['message' => 'Can\'t update others info'], 403);
        } else {
            $user = User::find($id);
            $user->update($request->all());
            return $user;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (Exception $e) {
            return response(['message' => 'Token required'], 400);
        }

        if ($user['role'] != 'admin') {
            return response(['message' => 'Can\'t delete others info'], 403);
        } else if (User::find($id) == null) {
            return response(['message' => 'User does not exist'], 404);
        } else {
            return User::destroy($id);
        }
    }

    public function uploadAvatar(Request $request) {
        $file = $request->file("profile_picture");

        if(!$file) {
            return response(['message' => 'No file uploaded'], 400);
        }

        try {
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (Exception $e) {
            return response(['message' => 'Token required'], 400);
        }

        $path = $file->store('public/avatars');
        $user->update(['profile_picture' => $path]);
    
        return response(["message" => "Avatar uploaded"]);
    }
}
