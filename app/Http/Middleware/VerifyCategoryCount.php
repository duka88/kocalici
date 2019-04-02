<?php

namespace App\Http\Middleware;

use Closure;
use App\Category;
use Session;
class VerifyCategoryCount
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
       if(Category::all()->count() == 0){

          session()->flash('error', 'Create category before creating a recipe');

          return redirect()->back();
       }
      
        return $next($request);
    }
}
