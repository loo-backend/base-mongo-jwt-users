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

        $this->administrator();
        $this->adminStaffSupport();
        $this->adminStaffFinance();
        $this->adminStaffCommercial();
        $this->adminStaffInitial();

    }


    public function administrator()
    {

        $roles = Role::ADMINISTRATOR;

        $users = factory(App\User::class,5)->create(['administrator' => User::ADMINISTRATOR_USER]);

        $users->each(function ($user) use($roles) {
            $user->roles()->create($roles);
        });

    }


    public function adminStaffSupport()
    {

        $roles = Role::ADMIN_STAFF_SUPPORT;

        $users = factory(App\User::class,50)->create(['administrator' => User::ADMINISTRATOR_USER]);

        $users->each(function ($user) use($roles) {
            $user->roles()->create($roles);
        });

    }

    public function adminStaffFinance()
    {

        $roles = Role::ADMIN_STAFF_FINANCE;

        $users = factory(App\User::class,50)->create(['administrator' => User::ADMINISTRATOR_USER]);

        $users->each(function ($user) use($roles) {
            $user->roles()->create($roles);
        });

    }

    public function adminStaffCommercial()
    {

        $roles = Role::ADMIN_STAFF_COMMERCIAL;

        $users = factory(App\User::class,50)->create(['administrator' => User::ADMINISTRATOR_USER]);

        $users->each(function ($user) use($roles) {
            $user->roles()->create($roles);
        });

    }


    public function adminStaffInitial()
    {

        $roles = Role::ADMIN_STAFF_INITIAL;

        $users = factory(App\User::class,50)->create(['administrator' => User::ADMINISTRATOR_USER]);

        $users->each(function ($user) use($roles) {
            $user->roles()->create($roles);
        });

    }


}
