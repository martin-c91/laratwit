<?php

use Faker\Generator as Faker;

$factory->define(App\Tweet::class, function (Faker $faker) {
    return [
        "content" =>  $faker->text(140),
        //user id here change all the time
        "user_id" =>  1
    ];
});
