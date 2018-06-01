<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\User::class,5)->create([
            'is_admin' => User::ADMIN_USER
        ]);

    }


}
