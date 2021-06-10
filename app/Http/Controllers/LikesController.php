<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Comment;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Exception;

class LikesController extends Controller
{
    public function likePost(Request $request, $id) {
        try {
            $this->validate($request, [
                'type' => 'required',
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid format of data'], 400);
        }

        $user = JWTAuth::user();

        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        Like::create(([
            'user_id' => $user->id,
            'post_id' => $id,
            'comment_id' => null,
            'type' => $request['type']
        ]));
    }

    public function getPostLike($id) {

    }

    public function deletePostLike($id) {

    }

    public function likeComment($id) {

    }

    public function getCommentLike($id) {

    }

    public function deleteCommentLike($id) {
        
    }
}
