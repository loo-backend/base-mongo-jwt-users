<?php

use App\Entities\Role;
use App\Entities\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
{

    public function run()
    {
        $this->generateUser(Role::ADMIN);
        $this->generateUser(Role::ADMIN_STAFF_INITIAL);
        $this->generateUser(Role::ADMIN_STAFF_COMMERCIAL);
        $this->generateUser(Role::ADMIN_STAFF_SUPPORT);
        $this->generateUser(Role::ADMIN_STAFF_FINANCE);
    }

    private function generateUser($typeRole)
    {

        $users = factory(User::class,100)->create();
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
