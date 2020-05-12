@extends('layouts.app')

@section('content')
 
    <div class="card">
        <div class="card-header">
            Edit Profile
            @include('partials.error')
        </div>
        <div class="card-body">
            <form action="{{ route('users.update')}}" method="POST" >
                @csrf    
                @method('PUT')
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" name="name" class="form-control" id="title" value="{{  $user->name }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="{{  $user->email }}">
                </div>
                <div class="form-group">
                    <label for="about">About</label>
                    <input id="about" type="hidden" name="about" value="{{ $user->about }}">
                    <trix-editor input="about"></trix-editor>
                </div>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css">
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js"></script>
@endsection
