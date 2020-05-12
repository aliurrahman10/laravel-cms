@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-end mb-2">
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Add Post</a>
    </div>
    <div class="card">
    	<div class="card-header">
    		Posts
			@include('partials.message')
    	</div>
        <div class="card-body">
@if(count($posts)>0)
<table class="table">
	<thead>
	<tr>
		<th>Image</th>
		<th>Title</th>
		<th>Category</th>
		<th class="text-center">Action</th>
	</tr>
	</thead>
	<tbody>
		@foreach($posts as $post)
			<tr>
				<td><img src="{{ asset('storage/'.$post->image) }}" width="80" height="60" alt=""></td>
				<td>{{ $post->title }}</td>
				<td>{{ $post->category->name }}</td>
				<td class="text-center">
					@if(!$post->trashed())
						<a class="btn btn-primary" href="{{ route('posts.edit', $post->id) }}">Edit</a>
					@else
						<form action="{{ route('restore-post', $post->id) }}" style="display: inline;" method="POST">
							@csrf
							@method('PUT')
							<button type="submit" class="btn btn-info text-white">Restore</button>
						</form>
					@endif
					<form style="display: inline;" action="{{ route('posts.destroy', $post->id) }}" method="POST">
						@csrf
						@method('DELETE')
						<button type="submit" class="btn btn-danger">{{ $post->trashed()?'Delete':'Trash' }}</button>
					</form>
				</td>

			</tr>
		@endforeach
	</tbody>
</table>
@else
<h3 class="text-center">No Post Yet</h3>
@endif
        </div>
    </div>
@endsection
