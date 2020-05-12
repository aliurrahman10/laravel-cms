@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add category</a>
    </div>
    <div class="card">
        <div class="card-header">
            Categories
            @include('partials.message')
            @include('partials.error-message')
        </div>
        <div class="card-body">
        @if(count($categories)>0)
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">{{ $category->name }} ({{ $category->posts->count() }})
                    <span class="float-right ml-2">
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </span>
                   @if(!$category->trashed()) 
                   <span class="float-right">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
                    </span>
                    @else
                    <span class="float-right ml-2">
                        <form action="{{ route('restore-category', $category->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-info text-white">Restore</button>
                        </form>
                    </span>
                    @endif
                </li>
            @endforeach
        </ul>
        @else
            <h3 class="text-center">No Categories Yet</h3>
        @endif
        </div>
    </div>
@endsection
