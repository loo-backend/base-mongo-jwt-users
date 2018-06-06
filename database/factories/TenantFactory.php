<?php

use Faker\Generator as Faker;

$factory->define(App\Tenant::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'companyName' => $faker->company
    ];
});
