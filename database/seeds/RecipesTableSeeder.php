<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Category;
use App\Recipe;
use Illuminate\Support\Facades\Hash;
class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(Recipe::class, 30)->create();

         $category1 = Category::create([
          'name' => 'Cake'
        ]);
         $category2 = Category::create([
          'name' => 'Cookies'
        ]);
          $category3 = Category::create([
          'name' => 'Main dish'
        ]);

           $tag1 = Tag::create([
          'name' => 'Sugar'
        ]);
         $tag2 = Tag::create([
          'name' => 'Flour'
        ]);
          $tag3 = Tag::create([
          'name' => 'Cocao'
        ]); 
          $tag4 = Tag::create([
          'name' => 'Cream'
        ]);   

              


          foreach(Recipe::all() as $recipe) {

          $recipe->tags()->attach([rand(1, 2),rand(3, 4)]);
           
        }
    }
}

   
