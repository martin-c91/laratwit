<?php

use Faker\Generator as Faker;

$factory->define(App\Tweet::class, function (Faker $faker) {
    return [
        'content' => $faker->text(50),
    ];
});
