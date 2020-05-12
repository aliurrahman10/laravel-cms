<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Http\Requests\Tags\CreateTagsRequest;
use App\Http\Requests\Tags\UpdateTagsRequest;

class TagsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         

        return view('tag.index')->with('tags', Tag::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTagsRequest $request)
    {


        $tag = new Tag();
        $tag->name = $request->name;
        $tag->save();

        session()->flash('message', 'Tag has been added successfully');

        return redirect(route('tags.index'));

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
    public function edit(Tag $tag)
    {
        
        return view('tag.create')->with('tag', $tag);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagsRequest $request, Tag $tag)
    {

        $tag->name = $request->name;
        $tag->save();

        session()->flash('message', 'Tag has been updated successfully');

        return redirect(route('tags.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tag = Tag::withTrashed()->where('id', $id)->firstOrFail();

        if($tag->trashed()){
            $tag->forceDelete();
        }else{
            if($tag->posts->count() > 0){
              session()->flash('error-message', 'You can not delete tag because it has posts');
              return redirect()->back();  
            }
            $tag->delete();
        }

        session()->flash('message', 'Tag has been deleted successfully');
        return redirect()->back();
    }

    public function trash(){
        $tags = Tag::onlyTrashed()->get();

        return view('tag.index')->with('tags', $tags);
    }

    public function restore($id){
        $tag = Tag::withTrashed()->where('id', $id)->firstOrFail();
        $tag->restore();

        session()->flash('message', 'Restored successfully');
        return redirect()->back();
    }


}
