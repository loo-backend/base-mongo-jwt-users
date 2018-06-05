<?php

namespace App\Services\RoleUser;


use App\Composite\UserRoleComposite;
use App\RoleUser;
use App\User;

/**
 * Class CreateRoleUserService
 * @package App\Services\RoleUser
 */
class CreateRoleUserService extends UserRoleComposite
{

    /**
     * Creating RoleUser
     *
     * @param User $user
     * @param $role
     * @return bool
     */
    public function create(User $user, $role)
    {

        $privileges = [];
        foreach ($role->privileges as $privilege) {
            array_push($privileges, $privilege->name);
        }

        $role_user = RoleUser::create([
            'user_uuid' => $user->user_uuid,
        ]);

        $data = [
            'name' => $role->name,
            'role_uuid' => $role->role_uuid,
            'privileges' => $privileges
        ];

        if (!$created = $role_user->roles()->create($data) ) {
            return false;
        }

        return $created;

    }

}
