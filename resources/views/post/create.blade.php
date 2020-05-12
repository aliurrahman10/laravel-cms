@extends('layouts.app')

@section('content')
 
    <div class="card">
        <div class="card-header">
            {{ isset($post) ? 'Edit Post' : 'Create Post' }}
            @include('partials.error')
        </div>
        <div class="card-body">
            <form action="{{ isset($post)? route('posts.update', $post->id) : route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($post))
                @method('PUT')
                @endif
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ isset($post)? $post->title : '' }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ isset($post)? $post->description : '' }}</textarea>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <input id="content" type="hidden" name="content" value="{{ isset($post)? $post->content : '' }}">
                    <trix-editor input="content"></trix-editor>
                </div>
                <div class="form-group">
                    <label for="published_at">Published at</label>
                    <input type="text" name="published_at" class="form-control" id="published_at" value="{{ isset($post)? $post->published_at : '' }}">
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                            @if(isset($post))
                            @if($category->id === $post->category_id)
                                selected 
                            @endif
                            @endif
                                >{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                @if($tags->count() > 0)
                    <div class="form-group">
                        <label for="tag">Tag</label>
                        <select name="tags[]" id="tag" class="form-control tag-selector" multiple>
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}"
                                @if(isset($post))
                                @if($post->hasTag($tag->id))
                                    selected 
                                @endif
                                @endif
                                    >{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control" id="image">
                </div>
                @if(isset($post))
                <div class="form-group">
                    <img src="{{asset('storage/'.$post->image) }}" alt="" style="height: 100px;width: 150px">
                </div>
                @endif
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ isset($post) ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
    flatpickr("#published_at", {
        enableTime: true
    });

    $(document).ready(function() {
        $('.tag-selector').select2();
    });
</script>
@endsection
