<?php

use App\Role;
use Illuminate\Database\Seeder;

class UserTenantSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->tenantAdmin();
        $this->tenantStaff();
        $this->tenantDevelop();
    }


    public function tenantAdmin()
    {

        $roles = Role::TENANT_ADMINISTRATOR;

        $users = factory(App\User::class,5)->create();
//
//        $users->each(function ($user) use($roles) {
//            $user->roles()->create($roles);
//        });

    }


    public function tenantStaff()
    {

        $roles = ['name' => 'TENANT_EDITOR',
            'permissions' => [
                'BROWSER',
                'READ',
                'ADD',
                'EDIT'
            ]
        ];

        $users = factory(App\User::class,50)->create();

//        $users->each(function ($user) use($roles) {
//            $user->roles()->create($roles);
//        });

    }

    public function tenantDevelop()
    {

        $roles = ['name' => 'TENANT_DEVELOP',
            'permissions' => [
                'BROWSER',
                'READ',
                'ADD',
                'EDIT'
            ]
        ];

        $users = factory(App\User::class,50)->create();
//
//        $users->each(function ($user) use($roles) {
//            $user->roles()->create($roles);
//        });

    }

}
