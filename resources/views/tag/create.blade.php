@extends('layouts.app')

@section('content')
 
    <div class="card">
        <div class="card-header">
            {{ isset($category)?'Edit Tag'  : 'Create Tag' }}
            @include('partials.error')
        </div>
        <div class="card-body">
            <form action="{{ isset($tag)? route('tags.update', $tag->id) : route('tags.store') }}" method="POST">
                @csrf
                @if(isset($tag))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Tag Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ isset($tag)? $tag->name :'' }}">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">{{ isset($tag)?'Update Tag':'Create Tag' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection