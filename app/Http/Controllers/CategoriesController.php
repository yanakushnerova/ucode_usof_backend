<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::all();
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
                'title' => 'max:50',
                'description' => 'max:200'
            ]);
        } catch (Exception $e) {
            return response(['message' => 'Invalid format of data'], 400);
        }

        $isUser = JWTAuth::user();
        
        if (!$isUser) {
            return response(['message' => 'Token required'], 400);
        }
        
        if ($isUser['role'] != 'admin') {
            return response(['message' => 'Forbidden action'], 403);
        } else {
            $category = Category::create([
                'title' => $request['title'],
                'description' => $request['description']
            ]);
    
            return $category;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (Category::find($id) == null) {
            return response(['message' => 'No such category'], 404);
        } else {
            return Category::find($id);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = JWTAuth::toUser(JWTAuth::getToken());
        } catch (Exception $e) {
            return response(['message' => 'Token required'], 400);
        }

        if ($user['role'] != 'admin') {
            return response(['message' => 'User is not admin'], 403);
        } else if (Category::find($id) == null) {
            return response(['message' => 'Category does not exist'], 404);
        } else {
            $category = Category::find($id);
            $category->update($request->all());

            try {
                $this->validate($request, [
                    'title' => 'max:50',
                    'description' => 'max:200'
                ]);

                return $category;
            } catch (Exception $e) {
                return response(['message' => 'Invalid format of data'], 400);
            }    
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
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
            return response(['message' => 'User is not admin'], 403);
        } else if (Category::find($id) == null) {
            return response(['message' => 'Category does not exist'], 404);
        } else {
            return Category::destroy($id);
        }
    }

    public function getPosts($id) {
        $category = Category::find($id);

        if (!$category) {
            return response(['message' => 'No such category'], 404);
        }

        $allPosts = Post::all();
        $posts = [];

        for ($i = 0; $i < count($allPosts); $i++) {
            if ($allPosts[$i]['category_id'] == $category['id']) {
                array_push($posts, $allPosts[$i]);
            }
        }

        return response()->json($posts);
    }
}
