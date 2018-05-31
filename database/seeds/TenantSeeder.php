<?php

use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $tenants = factory(\App\Tenant::class)->create();
//
//
//        $tenants->each(function ($tenant) {
//            $user = factory(\App\User::class)->create();
//
//            $tenant->users($user->id);
//        });


        $user = \App\User::first();
        // $user->roless()->attach( \App\Role::first() );

    }
}
