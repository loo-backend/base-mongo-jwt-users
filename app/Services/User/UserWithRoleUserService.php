<?php

namespace App\Services\User;

use App\User;

/**
 * Class UserWithRoleUserService
 * @package App\Services\User
 */
class UserWithRoleUserService
{

    /**
     * @param array $data
     * @return User|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function userWithRoleUser(array $data)
    {

        $user = User::with('rolesUser');

        if (!$user = $user->where($data)->first() ) {
            return false;
        }

        return $user;

    }

}
