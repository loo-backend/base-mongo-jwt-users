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
        $this->tenantAdmin();
        $this->tenantStaff();
        $this->tenantDevelop();
    }


    public function tenantAdmin()
    {

        $roles = Role::TENANT_ADMIN;

        $users = factory(User::class,5)->create([
            'is_tenant' => User::TENANT_USER
        ]);
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

        $users = factory(User::class,50)->create([
            'is_tenant' => User::TENANT_USER
        ]);

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
