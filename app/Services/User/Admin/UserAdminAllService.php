<?php

namespace App\Services\User\Admin;

use App\User;

class UserAdminAllService
{

    /**
     * All Users
     *
     * @return bool|array
     */
    public function all()
    {

        $filter = [
            ['is_administrator', true]
        ];

        if (!$user = User::where($filter)->paginate() ) {
            return false;
        }

        return $user;

    }

}
