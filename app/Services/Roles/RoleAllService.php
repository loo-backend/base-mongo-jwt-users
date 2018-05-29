<?php

namespace App\Services\Roles;

use App\Role;
use App\User;

/**
 * Class RoleAdminAllService
 * @package App\Services\Roles
 */
class RoleAdminAllService
{

    /**
     * Get All Roles Admin
     *
     * @return mixed
     */
    public function getAll()
    {

        return Role::where('administrator', User::ADMIN_USER)
            ->get();

    }

}
