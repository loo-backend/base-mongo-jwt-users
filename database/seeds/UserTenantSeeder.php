<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\User;

class UserTenantSeeder extends Seeder
{

    public function run()
    {
        $this->generateUser(Role::TENANT_ADMIN);
        $this->generateUser(Role::TENANT_EDITOR);
        $this->generateUser(Role::TENANT_EXPEDITION);
        $this->generateUser(Role::TENANT_PARTNER);
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
