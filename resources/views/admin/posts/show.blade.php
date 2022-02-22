@extends('layouts.dashboard')

@section('content')
    <section>
        <h2>{{ $post_to_show->title }}</h2>
        <p>{{ $post_to_show->content }}</p>
    </section>
@endsection