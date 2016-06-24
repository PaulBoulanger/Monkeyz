<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'bananas' => rand(50,9999999),
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Building::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName(),
        'time' => rand(20, 600),
        'bananas' => rand(20, 10000),
    ];
});

$factory->define(App\Technology::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName(),
        'time' => rand(20, 600),
        'bananas' => rand(20, 10000),
    ];
});
