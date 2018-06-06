<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{

    public function run()
    {
        $this->userAdmin();
        $this->generateUser(Role::ADMIN);
        $this->generateUser(Role::ADMIN_STAFF_INITIAL);
        $this->generateUser(Role::ADMIN_STAFF_COMMERCIAL);
        $this->generateUser(Role::ADMIN_STAFF_SUPPORT);
        $this->generateUser(Role::ADMIN_STAFF_FINANCE);
    }


    private function userAdmin()
    {
        factory(User::class,1)->create([
            'isAdmin' => User::ADMIN_USER
        ]);

    }

    private function generateUser($typeRole)
    {

        $users = factory(User::class,1)->create();
        $users->each(function ($user) use($typeRole) {

            $roleFirst = Role::where('name', $typeRole)->first();

            $role = $user->roles()->create([
                'name' => $roleFirst->name,
                'roleUuid' => $roleFirst->uuid,
            ]);

            $rolesAll = Role::where('name', $typeRole)->get();

            foreach ($rolesAll as $item) {

                foreach ($item->privileges as $privilege) {

                    $user->privileges()->create([
                        'roleId' => $role->id,
                        'roleUuid' => $roleFirst->uuid,
                        'name' => $privilege->name
                    ]);

                }

            }

        });

    }

}
