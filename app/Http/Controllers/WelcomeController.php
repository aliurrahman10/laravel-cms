<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class WelcomeController extends Controller
{
    public function index(){
	

    	$latest = Post::orderBy('created_at', 'desc')->first();

    	return view('welcome')
    	->with('posts', Post::search()->paginate(2))
    	->with('tags', Tag::all())
    	->with('categories', Category::all())
    	->with('latest', $latest);
    }


    public function category(Category $category){
    
    	return view('blog.category')
    	->with('posts', $category->posts()->search()->paginate(2))
    	->with('tags', Tag::all())
    	->with('categories', Category::all());


    }

    public function tag(Tag $tag){

    	return view('blog.tag')
    	->with('posts', $tag->posts()->search()->paginate(2))
    	->with('tags', Tag::all())
    	->with('categories', Category::all());
    	
    }
}
