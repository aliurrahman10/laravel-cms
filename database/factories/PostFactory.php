<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3),
        'description' => $faker->words(5),
        'content' => $faker->words(10),
        'category_id' => 1,
        'published_at' => now(),
        'image' => $faker->url                     
    ];
});
