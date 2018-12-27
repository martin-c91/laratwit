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

$factory->define(App\User::class, function (Faker $faker) {
    $slug = $faker->unique()->userName;
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'slug' => $slug,
        'avatar_file_name' => $slug.'.jpg',
        'description' => $faker->unique()->text(50),
        'password' => Hash::make('test'), // secret
        'remember_token' => str_random(10),
    ];
});
