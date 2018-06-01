<?php

namespace App\Observers;


use App\Role;
use App\RoleUser;
use App\User;

class RoleUserObserver
{

    public function created(User $user)
    {

        $role_user = RoleUser::create([
            'user_uuid' => $user->user_uuid,
        ]);

        if($user->is_tenant === User::TENANT_USER) {

            $role = Role::where('name', Role::TENANT_ADMIN)->first();

            $role_user->roles()->create([
                'name' => $role->name,
                'role_uuid' => $role->role_uuid,
                'privileges' => [$role->privileges],
            ]);
        }

    }

}
