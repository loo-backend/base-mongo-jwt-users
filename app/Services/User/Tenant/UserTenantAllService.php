<?php

namespace App\Services\User\Tenant;

use App\User;

class UserTenantAllService
{

    /**
     * All Users
     *
     * @return bool|array
     */
    public function all()
    {

        $filter = [
            ['is_administrator', false]
        ];

        if (!$user = User::where($filter)->paginate() ) {
            return false;
        }

        return $user;

    }

}
