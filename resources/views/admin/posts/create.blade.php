@extends('layouts.dashboard')

@section('content')
    <h1>Create new post</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.posts.store') }}" method="POST">
        @csrf
        @method('POST')

        {{-- Post title input --}}
        <div class="mb-3">
            <label for="title" class="form-label">Post Title</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
        </div>

        {{-- Categories select --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Seleziona categoria</label>
            <select class="form-select" id="category_id" name="category_id">
                <option value=""></option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Tag checkboxes --}}
        <div class="mb-3">
            <h5>Select Tags</h5>
            @foreach ($tags as $tag)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $tag->id }}" id="tag-{{ $tag->id }}" name="tags[]">
                    <label class="form-check-label" for="tag-{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                </div>
            @endforeach
        </div>

        {{-- Post content input --}}
        <div class="mb-3">
            <label for="content" class="form-label">Post Content</label>
            <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
        </div>
    
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection