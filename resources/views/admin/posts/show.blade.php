@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>{{ $post_to_show->title }}</h2>

        @if ($post_to_show->cover)
            <div class="my-3">
                <img src="{{ $post_to_show->cover }}" alt="{{$post_to_show->title}}" style="max-width: 500px">
            </div>
        @endif

        <h5><strong>Categoria:</strong>
            @if ($post_to_show->category)
                {{$post_to_show->category->name}}
            @else
                Nessuna
            @endif
        </h5>

        <h5>
            <strong>Tag:</strong>
            @forelse ($tags as $tag)
                {{$tag->name}}@if(!$loop->last), @endif
            @empty
            Nessuno 
            @endforelse
        </h5>

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