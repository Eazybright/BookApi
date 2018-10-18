<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Book::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'user_id' =>function () {
            return factory(App\User::class)->create()->id;
        },
        'description' => $faker->text,
        'image' => $faker->imageUrl($width = 100, $height = 100)
    ];
});
