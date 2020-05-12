<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostsRequest;
use App\Http\Requests\Posts\UpdatePostsRequest;
use App\Post;
use App\Category;
use App\Tag;

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('VarifyCategoriesCount')->only(['create', 'store']);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('post.index')->with('posts', Post::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create')->with('categories', Category::all())->with('tags', Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostsRequest $request)
    {

       $image = $request->image->store('posts');
       $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'user_id' => auth()->user()->id,
            'category_id' => $request->category,
            'published_at' => $request->published_at,
            'image' => $image
        ]);

       if($request->tags){
            $post->tags()->attach($request->tags);
       }

        session()->flash('message', 'Post has been successfully uploaded');
        return redirect(route('posts.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.create')->with('post', $post)->with('categories', Category::all())->with('tags', Tag::all());
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostsRequest $request, Post $post)
    {
        $data = $request->only(['title','content','description','category_id', 'published_at']);
        if($request->hasFile('image')){

            $image = $request->image->store('posts');

            $post->deleteImage();

            $data['image'] = $image;
        }

        $post->update($data);

        if($request->tags){
            $post->tags()->sync($request->tags);
        }

        session()->flash('message', 'Updated successfully');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        if($post->trashed()){
            $post->deleteImage();
            $post->forceDelete();
        }else{
            $post->delete();
        }
        
        session()->flash('message', 'Deleted successfully');
        return redirect()->back();

    }

    public function trash(){
        $trashed = Post::onlyTrashed()->get();

        return view('post.index')->with('posts', $trashed);
    }

    public function restore($id){
        $post = Post::withTrashed()->where('id', $id)->firstOrFail();
        $post->restore();

        session()->flash('message','Restored successfully');

        return redirect()->back();
    }
}
