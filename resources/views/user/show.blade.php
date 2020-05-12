@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h4>Name : {{ $user->name }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h4>Role : {{ $user->role }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h4>Email : {{ $user->email }}</h4>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<h4>About : </h4>
			<p>{!!html_entity_decode($user->about)!!}</p>
		</div>
	</div>
</div>

@endsection
