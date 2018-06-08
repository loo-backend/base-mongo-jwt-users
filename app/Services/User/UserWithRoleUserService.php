<?php

namespace App\Services\User;

use App\Composite\UserRoleComposite;
use App\Entities\Role;
use App\Entities\User;

/**
 * Class UserWithRoleUserService
 * @package App\Services\User
 */
class UserWithRoleUserService extends UserRoleComposite
{


    public function getUserTenant()
    {

        $user = User::with('rolesUser')->first();

        $user->whereHas('rolesUser', function ($q) {
            $q->where(
                'roles',
                'elemMatch',
                [ 'name' => Role::TENANT_ADMIN ]
            );

        });

        return $user->first();

    }

}
