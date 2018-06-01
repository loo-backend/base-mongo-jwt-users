<?php

use App\User;
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

    $active = rand(0,10);

    if($active > 0) {
        $active = true;
    } else {
        $active = false;
    }

    return [
        'user_uuid' => $faker->uuid,
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
        'active' => $active,
        'verified' => $faker->randomElement([true, false]),
        'verification_token' => str_random(32)
    ];
});

