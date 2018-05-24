<?php

namespace App\Services\User;

use App\User;

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