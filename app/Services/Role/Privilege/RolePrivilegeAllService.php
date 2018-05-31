<?php

namespace App\Services\Role\Privilege;

use App\Privilege;

/**
 * Class RolePrivilegeAllService
 * @package App\Services\Role
 */
class RolePrivilegeAllService
{

    public function all()
    {

        if (!$privileges = Privilege::all()) {
            return false;
        }

        return $privileges;
    }

}
