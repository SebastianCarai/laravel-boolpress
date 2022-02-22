@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>{{ $post_to_show->title }}</h2>
        <p><b>Slug: </b>{{ $post_to_show->slug }}</p>
        <p>{{ $post_to_show->content }}</p>

        <a href="{{ route('admin.posts.edit',['post' => $post_to_show->id]) }}" class="btn btn-primary">Edit Post</a>

        <form action="{{ route('admin.posts.destroy' , ['post' => $post_to_show->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger mt-2"> Delete Post </button>
        </form>
    </section>
@endsection