<?php

use Illuminate\Database\Seeder;

class TenantTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $tenants = factory(\App\Entities\Tenant::class)->create();
        $tenants->each(function ($tenant) {

            $tenant->databases()->create([
                'driver' => 'mongodb',
                'host'     => env('DB_HOST_TENANT', 'localhost'),
                'port'     => env('DB_PORT_TENANT', 27017),
                'database' => env('DB_DATABASE_TENANT'),
                'username' => env('DB_USERNAME_TENANT'),
                'password' => env('DB_PASSWORD_TENANT'),
                'options'  => [
                    'database' => 'admin' // sets the authentication database required by mongo 3
                ]
            ]);

        });

    }

}
