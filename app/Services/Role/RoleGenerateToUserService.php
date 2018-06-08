<?php

namespace App\Services\Role;

use App\Entities\Role;
use App\Entities\User;

class RoleGenerateToUserService
{

    /**
     * Create Role User
     *
     * @param User $users
     * @param $typeRole
     */
    public function generateRole(User $users, string $typeRole)
    {

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
