@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>{{ $post_to_show->title }}</h2>
        <p><b>Slug: </b>{{ $post_to_show->slug }}</p>
        <p>{{ $post_to_show->content }}</p>

        <a href="{{ route('admin.posts.edit',['post' => $post_to_show->id]) }}" class="btn btn-primary">Edit Post</a>
    </section>
@endsection