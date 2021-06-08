<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $user = User::create([
            'login' => $request['login'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        if (User::find($user_id) == null) {
            return response(['message' => 'User does not exist'], 404);
        } else {
            return User::find($user_id);
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
        if (User::find($id) == null) {
            return response(['message' => 'User does not exist'], 404);
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
    public function destroy($user_id)
    {
        // if ($user['role'] != 'admin') {
        //     return response(['message' => 'User is not an admin'], 403);
        // } else 
        if (User::find($user_id) == null) {
            return response(['message' => 'User does not exist'], 403);
        } else {
            return User::destroy($user_id);
        }
    }
}
