<?php

use Faker\Generator as Faker;

$factory->define(App\Entities\Log::class, function (Faker $faker) {
    return [
        'action' => $faker->randomElement(['CREATED', 'DELETED', 'UPDATED', 'RESTORED']),
        'description' => $faker->paragraph,
    ];
});


//retrieved,
// creating,
// created,
// updating,
// updated,
// saving,
// saved,
// deleting,
// deleted,
// restoring,
// restored.
