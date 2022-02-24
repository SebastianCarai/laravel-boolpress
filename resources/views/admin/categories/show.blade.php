@extends('layouts.dashboard')

@section('content')
    <h1>Lista dei post riferiti alla categoria: {{ $category_to_show->name }}</h1>

    <ul>
        @forelse ($posts as $post)
            <li>
                <a href="{{ route('admin.posts.show', ['post' => $post->id]) }}">
                    {{ $post->title }}
                </a>
            </li>
        @empty
            <li>
                Non ci sono post
            </li>
        @endforelse
    </ul>
@endsection