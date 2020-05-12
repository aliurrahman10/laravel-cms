<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Http\Requests\Categories\CreateCategoriesRequest;
use App\Http\Requests\Categories\UpdateCategoriesRequest;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         

        return view('category.index')->with('categories', Category::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoriesRequest $request)
    {


        $category = new Category();
        $category->name = $request->name;
        $category->save();

        session()->flash('message', 'Category has been added successfully');

        return redirect(route('categories.index'));

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
    public function edit(Category $category)
    {
        
        return view('category.create')->with('category', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriesRequest $request, Category $category)
    {

        $category->name = $request->name;
        $category->save();

        session()->flash('message', 'Category has been updated successfully');

        return redirect(route('categories.index'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::withTrashed()->where('id', $id)->firstOrFail();

        if($category->trashed()){
            $category->forceDelete();
        }else{

            if($category->posts->count() > 0){

                session()->flash('error-message', 'You can not delete Category because it has posts');
                return redirect()->back();
            }

            $category->delete();
        }

        session()->flash('message', 'Category has been deleted successfully');
        return redirect()->back();
    }

    public function trash(){
        $categories = Category::onlyTrashed()->get();

        return view('category.index')->with('categories', $categories);
    }

    public function restore($id){
        $category = Category::withTrashed()->where('id', $id)->firstOrFail();
        $category->restore();

        session()->flash('message', 'Restored successfully');
        return redirect()->back();
    }


}
