<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tag;


class TagController extends Controller
{
    public function show($slug){
        $tag_to_show = Tag::where('slug', '=', $slug)->with('posts')->first();
        if($tag_to_show){
            $response =[
                'success' => true,
                'tag_to_show' => $tag_to_show,
                'tag_posts' => $tag_to_show->posts
            ];
        }else{
            $response =[
                'success' => false,
                'tag_to_show' => null,
                'tag_posts' => null
            ];
        }


        return response()->json($response);
    }
}
