<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Recipe;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       $recipes = Recipe::withCount(['scores as average' => function ($q){
                            $q->select(DB::raw('coalesce(avg(score), 0)'));
                          }])->orderBy('average' , 'DESC')->take(5)->get();
       

         View::share('top_recipes', $recipes);
    }
}
