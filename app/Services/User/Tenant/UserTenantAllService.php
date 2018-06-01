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

        $user = User::where('is_tenant', User::TENANT_USER)
                        ->paginate();

        if (!$user) {
            return false;
        }

        return $user;

    }

}
