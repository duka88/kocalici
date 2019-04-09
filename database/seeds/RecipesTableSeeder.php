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
        $category1 = Category::create([
          'name' => 'Cake'
        ]);
         $category2 = Category::create([
          'name' => 'Cookies'
        ]);
          $category3 = Category::create([
          'name' => 'Main dish'
        ]);

        $auth1 = App\User::create([
          'name' => 'John Doe',
          'email' => 'john@mail.com',
          'password' => Hash::make('password')
        ]);  

          $auth2 = App\User::create([
          'name' => 'Jone Doe',
          'email' => 'jone@mail.com',
          'password' => Hash::make('password')
        ]);  


        $recipe1 = Recipe::create([
          'title' => 'That is Lorem Ipsum',
          'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy ',
          'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular ',
          'category_id' => $category1->id,
          'image' => 'recipes/1.jpg',
          'user_id' => $auth1->id,
          'published_at' => now()
        ]);  
         $recipe2 = Recipe::create([
          'title' => 'Best is Lorem Ipsum',
          'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy ',
          'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular ',
          'category_id' => $category2->id,
          'image' => 'recipes/2.jpg',
          'user_id' => $auth1->id
        ]); 
          $recipe3 = $auth2->recipes()->create([
          'title' => 'One is Lorem Ipsum',
          'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy ',
          'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular ',
          'category_id' => $category3->id,
          'image' => 'recipes/3.jpg',
           'published_at' => now()
          
        ]); 
           $recipe4 = Recipe::create([
          'title' => 'What is Lorem Ipsum',
          'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy ',
          'content' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular ',
          'category_id' => $category3->id,
          'image' => 'recipes/4.jpg',
          'user_id' => $auth2->id,
           'published_at' => now()
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

         $recipe1->tags()->attach([$tag1->id, $tag2->id]);
         $recipe2->tags()->attach([$tag2->id, $tag3->id]);
         $recipe3->tags()->attach([$tag3->id, $tag2->id]);
         $recipe4->tags()->attach([$tag1->id, $tag3->id]);

    }
}
