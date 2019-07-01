<?php

use App\Recipe;
use Faker\Generator as Faker;

$factory->define(Recipe::class, function (Faker $faker) {
 $images=(['cake1.jpg','cake2.jpg','cake3.jpg','cake4.jpg']);
 $number=([1,2,3,]);
 $title = $faker->text(5);
 $slug = str_slug($title);

    return [
        'title' => $title,
        'slug' => $slug,
        'content' => $faker->text(200),
        'image' => $faker->randomElement($images),
        'time'=> $faker->randomDigitNotNull(),
        'dificulty'=> $faker->randomDigitNotNull(),
        'servings'=> $faker->randomDigitNotNull(),
        'description' =>  $faker->text(50),
        'category_id' => $faker->randomElement( $number),
        'user_id' => 1
    ];
});


