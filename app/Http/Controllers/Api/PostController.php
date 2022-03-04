<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index(){
        $posts = Post::paginate(6);

        $response = [
            'success' => true,
            'posts' => $posts
        ];

        return response()->json($response);
    }

    public function show($slug){
        $post_to_show = Post::where('slug', '=', $slug)->with(['category', 'tags'])->first();
        // If the result is not null, the api will return the desired post, otherwise it will return a null.
        // Then, in the getPostDetails() method of the PostDetails.vue page, if the returned object is null, 
        // the function will redirect the user to the 404 page.
        if ($post_to_show){
            $result = [
                'success' => true,
                'post_to_show' => $post_to_show,
                'category' => $post_to_show->category,
                'tags' => $post_to_show->tags
            ];
        }else{
            $result = [
                'success' => false,
                'post_to_show' => null
            ];
        }

        return response()->json($result);
    }
}
