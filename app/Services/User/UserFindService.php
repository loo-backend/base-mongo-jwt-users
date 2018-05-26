<?php

namespace App\Services\User;

use App\User;

/**
 * Class UserFindService
 * @package App\Services\User
 */
class UserFindService
{

    /**
     * Find User
     *
     * @param $id
     * @return bool|array
     */
    public function findBy($id)
    {

        if (!$user = User::find($id) ) {
            return false;
        }

        return $user;

    }

}
