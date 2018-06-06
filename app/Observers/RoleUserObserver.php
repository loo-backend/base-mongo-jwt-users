<?php

namespace App\Observers;


use App\Privilege;
use App\Role;
use App\RoleUser;
use App\User;

class RoleUserObserver
{

    public function created(User $user)
    {

        $role_user = RoleUser::create([
            'userUuid' => $user->uuid,
        ]);

        if($user->isAdmin === User::ADMIN_USER) {

            $role = Role::where('name', Role::ADMIN_STAFF_INITIAL)->first();

            $privileges = [];
            foreach ($role->privileges as $privilege) {
                array_push($privileges, $privilege->name);
            }

            $role_user->roleUser()->create([
                'name' => $role->name,
                'role_uuid' => $role->role_uuid,
                'privileges' => $privileges
            ]);

        }

    }

}
