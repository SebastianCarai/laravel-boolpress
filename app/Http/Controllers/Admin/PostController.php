<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use App\Category;
use App\Tag;
use Illuminate\Support\Facades\Storage;


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
        // Get the data from the form compiled by the user
        $form_data = $request->all();

        // Validate the form data
        $request->validate($this->formValidation());

        // Storing the validated data in the db
        $new_post = new Post();
        $new_post->title = $form_data['title'];
        $new_post->content = $form_data['content'];
        $new_post->slug = $this->slugValidation($new_post->title);
        $new_post->category_id = $form_data['category_id'];

        // Store the image in the public/storage/uploads folder
        $img_path = Storage::put('uploads', $form_data['cover']);
        // Store in the db
        $new_post->cover = $img_path;


        $new_post->save();

        // If the tag key exists, it creates the rows in the post_tag table
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
        // Get the data from the form compiled by the user
        $form_data = $request->all();

        // Validate the form data
        $request->validate($this->formValidation());

        // Search the post in the db (the $id is taken from the url)
        $post = Post::findOrFail($id);

        // If the user changed the title, then it changes also the slug
        if($form_data['title'] != $post->title){
            $form_data['slug'] = $this->slugValidation($form_data['title']);
        }

        if(isset($form_data['cover']) && $form_data['cover'] != $post->cover){
            Storage::delete($post->cover);
            $new_path = Storage::put('uploads', $form_data['cover']);
            $post->cover = $new_path;
        }

        $post->update($form_data);

        // If the tags exists change them, or store as new tags
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
            'tags' => 'exists:tags,id|nullable',
            'cover' => 'image|nullable'

        ];
    }

    public function slugValidation($title){
        // Till the function finds another slug in the DB (equal to the one we want to save), 
        // it adds a "-" at the end of the new slug, followed by a number set by a counter
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
