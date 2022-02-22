@extends('layouts.dashboard')

@section('content')
    <h1>Posts List</h1>

    <div class="row row-cols-5">
        @forelse ($posts as $post)
            <div class="col">
                <div class="card mb-3" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{$post->title}}</h5>
                        <p class="card-text">{{Str::substr($post->content, 0, 50)}}.....</p>
                        <a href="{{route('admin.posts.show', ['post' => $post->id])}}" class="btn btn-primary">View Post</a>
                    </div>
                </div>
            </div>
        @empty
            <h2>Non ci sono post disponibili</h2>
        @endforelse
    </div>
@endsection