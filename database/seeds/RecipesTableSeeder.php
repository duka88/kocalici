<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\Category;
use App\Recipe;
use App\Score;
use App\Like;
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
          'name' => 'Cake',
          'slug' =>  'cake'
        ]);
         $category2 = Category::create([
          'name' => 'Cookies',
          'slug' =>  'cookies'
        ]);
          $category3 = Category::create([
          'name' => 'Main dish',
          'slug' =>  'main_dish'
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
          
         
          
          $recipe->scores()->create(['score' => rand(1,10), 'comment' => '<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy </p>', 'user_id'=>1] );
          $recipe->tags()->attach([rand(1, 2),rand(3, 4)]);
           
        }
    }
}

   
