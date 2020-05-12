@extends('layouts.app')

@section('content')
    <div class="card">
    	<div class="card-header">
    		Users
			@include('partials.message')
    	</div>
        <div class="card-body">
@if(count($users)>0)
<table class="table">
	<thead>
	<tr>
		<th>Image</th>
		<th>Name</th>
		<th>Email</th>
		<th class="text-center">Action</th>
	</tr>
	</thead>
	<tbody>
		@foreach($users as $user)
			<tr>
				<td><img height="40px" width="40px" style="border-radius: 50%" src="{{ Gravatar::src($user->email) }}"></td>
				<td><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></td>
				<td>{{ $user->email }}</td>
				<td>
				@if(!$user->isAdmin())
					<form action="{{ route('users.make-admin', $user->id) }}" style="display: inline;" method="POST">
						@csrf
						<button type="submit" class="btn btn-info text-white">Make Admin</button>
					</form>
				@endif
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
