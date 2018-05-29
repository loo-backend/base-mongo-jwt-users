<?php

use Faker\Generator as Faker;

$factory->define(App\Tenant::class, function (Faker $faker) {
    return [
        'tenant_uuid' => $faker->uuid,
        'company_name' => $faker->company
    ];
});
