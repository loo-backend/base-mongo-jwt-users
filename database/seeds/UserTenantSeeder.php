<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\User;

class UserTenantSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class,5)->create([
            'is_tenant' => User::TENANT_USER
        ]);
    }

}
