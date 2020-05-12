<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\Users\UsersUpdateRequest;

class UsersController extends Controller
{
    public function index(){

    	return view('user.index')->with('users', User::all());
    }

    public function makeAdmin(User $user){
    	$user->role = 'admin';
    	$user->save();

    	session()->flash('message', 'Successfully make administrator');

    	return redirect()->back();
    }

    public function edit(){

    	return view('user.edit')->with('user', auth()->user());
    }

    public function update(UsersUpdateRequest $request){


    		$user = auth()->user();

    		$user->name = $request->name;
    		$user->email = $request->email;
    		$user->about = $request->about;

    		$user->save();

    		session()->flash('message', 'Profile Updated Successfully');
    		return redirect(route('users.edit'));
    }

    public function show(User $user){
    	return view('user.show')->with('user', $user);
    }
}
