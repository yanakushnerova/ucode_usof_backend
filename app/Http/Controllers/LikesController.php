<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;

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

        $post = Post::find($id);

        if ($post == null) {
            return response(['message' => 'No such post'], 404);
        }

        $creatorId = DB::table('posts')->where('id', $id)->value('user_id');
        $creatorRating = DB::table('users')->where('id', $creatorId)->value('rating');

        $like = DB::table('likes')->where('user_id', $user->id)->where('post_id', $id)->get();
        $likeType = DB::table('likes')->where('user_id', $user->id)->where('post_id', $id)->value('type');
        
        if ($like == null || $request['type'] != $likeType) {
            if ($request['type'] == 'like') {
                $creatorRating++;
            } else if ($request['type'] == 'dislike') {
                $creatorRating--;
    
                if ($creatorRating < 0) {
                    $creatorRating == 0;
                }
            }
        }

        DB::table('likes')->where('user_id', $user->id)->where('post_id', $id)->delete();

        Like::create(([
            'user_id' => $user->id,
            'post_id' => $id,
            'comment_id' => null,
            'type' => $request['type']
        ]));

        DB::table('users')->where('id', $creatorId)->update(['rating' => $creatorRating]);
    }

    public function getPostLike($id) {
        if (Post::find($id) == null) {
            return response(['message' => 'No such post'], 404);
        } else {
            $likes = DB::table('likes')->where('post_id', $id)->get();

            if (count($likes) == 0) {
                return response(['message' => 'No likes under post']);
            }

            return $likes;
        }
    }

    public function deletePostLike($id) {
        $user = JWTAuth::user();
        
        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        $post = Post::find($id);
        
        if ($post == null) {
            return response(['message' => 'No such post'], 404);
        } else {
            $like = DB::table('likes')->where('user_id', $user->id)->where('post_id', $id);
            $like->delete();
        }
    }

    public function likeComment(Request $request, $id) {
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

        $creatorId = DB::table('comments')->where('id', $id)->value('user_id');
        $creatorRating = DB::table('users')->where('id', $creatorId)->value('rating');

        $like = DB::table('likes')->where('user_id', $user->id)->where('comment_id', $id)->get();
        $likeType = DB::table('likes')->where('user_id', $user->id)->where('comment_id', $id)->value('type');

        if ($like == null || $request['type'] != $likeType) {
            if ($request['type'] == 'like') {
                $creatorRating++;
            } else if ($request['type'] == 'dislike') {
                $creatorRating--;
    
                if ($creatorRating < 0) {
                    $creatorRating == 0;
                }
            }
        }

        DB::table('likes')->where('user_id', $user->id)->where('comment_id', $id)->delete();

        Like::create(([
            'user_id' => $user->id,
            'post_id' => null,
            'comment_id' => $id,
            'type' => $request['type']
        ]));

        DB::table('users')->where('id', $creatorId)->update(['rating' => $creatorRating]);
    }

    public function getCommentLike($id) {
        if (Post::find($id) == null) {
            return response(['message' => 'No such post'], 404);
        } else {
            $likes = DB::table('likes')->where('comment_id', $id)->get();

            if (count($likes) == 0) {
                return response(['message' => 'No likes under comment']);
            }

            return $likes;
        }
    }

    public function deleteCommentLike($id) {
        $user = JWTAuth::user();
        
        if (!$user) {
            return response(['message' => 'Token required'], 400);
        }

        $post = Post::find($id);
        
        if ($post == null) {
            return response(['message' => 'No such post'], 404);
        } else {
            $like = DB::table('likes')->where('user_id', $user->id)->where('comment_id', $id);
            $like->delete();
        }
    }
}
