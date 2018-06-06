<?php

namespace App\Services\User;

use App\Composite\UserRoleComposite;
use App\Role;
use App\User;

/**
 * Class UserWithRoleUserService
 * @package App\Services\User
 */
class UserWithRoleUserService extends UserRoleComposite
{

    /**
     * @param array $data
     * @return User|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
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
