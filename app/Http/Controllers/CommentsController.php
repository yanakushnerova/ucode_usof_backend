<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class CommentsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Comment::find($id) == null) {
            return response(['message' => 'No such comment'], 404);
        } else {
            return Comment::find($id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = JWTAuth::user();
        
        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        $comment = Comment::find($id);
        
        if ($comment == null) {
            return response(['message' => 'No such post'], 404);
        } else if ($user['role'] != 'admin' && $comment['user_id'] != $user['id']) {
            return response(['message' => 'Can\'t update others info'], 403);
        } else {
            $comment->update($request->all());
            return $comment;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
