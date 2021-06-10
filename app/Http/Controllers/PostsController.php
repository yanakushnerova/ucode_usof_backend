<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:200',
                'content' => 'required|max:4000',
                'category_id' => 'required',
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid format of data'], 400);
        }

        $user = JWTAuth::user();

        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        Post::create(([
            'user_id' => $user->id,
            'title' => $request['title'],
            'content' => $request['content'],
            'category_id' => $request['category_id']
        ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Post::find($id) == null) {
            return response(['message' => 'No such post'], 404);
        } else {
            return Post::find($id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::user();
        
        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        $post = Post::find($id);
        
        if ($post == null) {
            return response(['message' => 'No such post'], 404);
        } else if ($user['role'] != 'admin' && $post['user_id'] != $user['id']) {
            return response(['message' => 'Can\'t update others info'], 403);
        } else {
            $post->update($request->all());
            return $post;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = JWTAuth::user();
        
        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        $post = Post::find($id);
        
        if ($post == null) {
            return response(['message' => 'No such post'], 404);
        } else if ($user['role'] != 'admin' && $post['user_id'] != $user['id']) {
            return response(['message' => 'Can\'t delete others info'], 403);
        } else {
            return Post::destroy($id);
        }
    }
}
