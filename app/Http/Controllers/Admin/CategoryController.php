<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Post;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::all();

        $data = [
            'categories' => $categories
        ];

        return view('admin.categories.index', $data);
    }

    public function show($slug){
        $category_to_show = Category::where('slug', '=', $slug)->first();
        $posts = Post::where('category_id', '=', $category_to_show->id)->get();

        if(!$category_to_show){
            abort('404');
        }

        $data = [
            'category_to_show' => $category_to_show,
            'posts' => $posts
        ];

        return view('admin.categories.show', $data);
    }
}
