<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Tenant::class, function (Faker $faker) {
    return [
        'uuid' => $faker->uuid,
        'companyName' => $faker->company,
        'limitUser' => random_int(2,5)
    ];
});
