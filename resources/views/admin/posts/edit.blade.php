@extends('layouts.dashboard')

@section('content')
    <h1>Edit the post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.update', ['post' => $post_to_edit->id]) }}" method="POST" enctype="multipart/form-data"> 
        @csrf
        @method('PUT')

        {{-- Post title input --}}
        <div class="mb-3">
            <label for="title" class="form-label">Post Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $post_to_edit->title) }}">
        </div>

        {{-- File input --}}
        <div class="mb-3">
            <h5>Cover</h5>
            <label for="cover" class="form-label">Select image</label>
            <input type="file" id="cover" name="cover">
        </div>
        {{-- If the image already exists --}}
        @if ($post_to_edit->cover)
            <div class="my-3">
                <span>Your current cover:</span>
                <img src="{{ asset('storage/' . $post_to_edit->cover) }}" alt="{{$post_to_edit->title}}" style="max-width: 200px">
            </div>
        @endif

        {{-- Categories select --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Seleziona categoria</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $post_to_edit->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tag checkboxes --}}
        <div class="mb-3">
            <h5>Edit Tags</h5>
            @foreach ($tags as $tag)
                <div class="form-check">

                    @if ($errors->any())
                        <input  
                            class="form-check-input" 
                            type="checkbox" 
                            value="{{ $tag->id }}" 
                            id="tag-{{ $tag->id }}" 
                            name="tags[]"
                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} 
                        \>
                    @else
                        <input  
                            class="form-check-input" 
                            type="checkbox" 
                            value="{{ $tag->id }}" 
                            id="tag-{{ $tag->id }}" 
                            name="tags[]"
                            {{-- The contains() methods checks if the function's argument can be found in the Collection --}}
                            {{$post_tags->contains($tag->id) ? 'checked' : ''}}
                        \> 
                    @endif

                    <label class="form-check-label" for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                </div>
            @endforeach
        </div>

        {{-- Post content input --}}
        <div class="mb-3">
            <label for="content" class="form-label">Post Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content', $post_to_edit->content) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
@endsection