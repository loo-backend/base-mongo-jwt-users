<?php

namespace App\Services;

use App\User;

/**
 * Class UserWhereFirstService
 * @package App\Services
 */
class UserWhereFirstService
{

    /**
     * Find User
     *
     * @param array $data
     * @return bool
     */
    public function whereFirst(array $data)
    {

        if (!$user = User::where($data)->first() ) {
            return false;
        }

        return $user;

    }

}
