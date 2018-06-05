<?php


namespace App\Services\User;


use App\Composite\UserRoleComposite;
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
    public function getUserTenant(array $data)
    {

        $user = User::with('rolesUser');

        if (!$user = $user->where($data)->first() ) {
            return false;
        }

        return $user;

    }

}
