<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\Tag;


class PostController extends Controller
{
    /**
     * ! Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
    
        $data = [
            'posts' => $posts
        ];

        return view('admin.posts.index', $data);
    }

    /**
     * ! Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $data =[
            'categories' => $categories,
            'tags' => $tags
        ];

        return view('admin.posts.create', $data);
    }

    /**
     * ! Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form_data = $request->all();

        $request->validate($this->formValidation());

        $new_post = new Post();
        $new_post->title = $form_data['title'];
        $new_post->content = $form_data['content'];
        $new_post->slug = $this->slugValidation($new_post->title);
        $new_post->category_id = $form_data['category_id'];
        $new_post->save();

        if(isset($form_data['tags'])){
            $new_post->tags()->sync($form_data['tags']);
        }else{
            $new_post->tags()->sync([]);
        }

        return redirect()->route('admin.posts.show',['post' => $new_post->id]);
    }

    /**
     * ! Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post_to_show = Post::findOrFail($id);
        // dd($post_to_show->category);
        $data = [
            'post_to_show' => $post_to_show,
            'tags' => $post_to_show->tags
        ];

        return view('admin.posts.show', $data);
    }

    /**
     * ! Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post_to_edit = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();

        $data = [
            'post_to_edit' => $post_to_edit,
            'categories' => $categories,
            'tags' => $tags,
            'post_tags' => $post_to_edit->tags
        ];
        return view('admin.posts.edit', $data);
    }

    /**
     * ! Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form_data = $request->all();
        $request->validate($this->formValidation());
        $post = Post::findOrFail($id);
        if($form_data['title'] != $post->title){
            $form_data['slug'] = $this->slugValidation($form_data['title']);
        }

        $post->update($form_data);

        if (isset($form_data['tags'])){
            $post->tags()->sync($form_data['tags']);
        } else{
            $post->tags()->sync([]);
        }

        return redirect()->route('admin.posts.show',['post' => $post->id]);

    }

    /**
     * ! Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('admin.posts.index');
    }

    public function formValidation(){
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:60000',
            'category_id' => 'exists:categories,id|nullable',
            'tags' => 'exists:tags,id|nullable'

        ];
    }

    public function slugValidation($title){
        // Till the function finds another slug in the DB (equal to the one we want to save), 
        // this function adds a "-" at the end of the new slug, followed by a number set by a counter
        $slug = Str::slug($title);
        $slug_base = $slug;

        $is_slug_in_db = Post::where('slug', '=' , $slug)->first();
        $counter = 1;
        while ($is_slug_in_db){
            $slug = $slug_base . '-' . $counter;
            $is_slug_in_db = Post::where('slug', '=' , $slug)->first();
            $counter ++;
        }
        return $slug;
    }
}
