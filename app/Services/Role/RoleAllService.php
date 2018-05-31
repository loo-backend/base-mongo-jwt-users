<?php

namespace App\Services\Role;

use App\Role;

/**
 * Class RoleAdminAllService
 * @package App\Services\Roles
 */
class RoleAllService
{

    public function all($user)
    {

        if (!$roles = Role::where('administrator', $user)->get()) {
            return false;
        }

        return $roles;
    }

}
