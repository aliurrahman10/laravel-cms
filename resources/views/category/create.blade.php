@extends('layouts.app')

@section('content')
 
    <div class="card">
        <div class="card-header">
            {{ isset($category)?'Edit Category'  : 'Create Category' }}
            @include('partials.error')
            @include('partials.error-message')
        </div>
        <div class="card-body">
            <form action="{{ isset($category)? route('categories.update', $category->id) : route('categories.store') }}" method="POST">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ isset($category)? $category->name :'' }}">
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">{{ isset($category)?'Update Category':'Create Category' }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection