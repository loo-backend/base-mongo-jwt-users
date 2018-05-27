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

        $user = User::where('administrator', User::REGULAR_USER)
                        ->paginate();

        if (!$user) {
            return false;
        }

        return $user;

    }

}
