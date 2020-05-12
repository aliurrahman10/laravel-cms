<?php

namespace App\Http\Middleware;
use App\Category;
use Closure;

class VarifyCategoriesCount
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Category::all()->count() === 0){

            session()->flash('error-message', 'You should have Created Category first to create a post');
            return redirect(route('categories.create'));
        }
        return $next($request);
    }
}
