<?php

namespace App\Services\Role;

use App\Role;
use App\User;

/**
 * Class RoleAdminAllService
 * @package App\Services\Roles
 */
class RoleAllService
{

    private $admin;
    private $tenant;

    /**
     * @param mixed $admin
     * @return RoleAllService
     */
    public function admin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    /**
     * @param mixed $tenant
     * @return RoleAllService
     */
    public function tenant($tenant)
    {
        $this->tenant = $tenant;
        return $this;
    }

    public function all()
    {

        if($this->admin === User::ADMIN_USER) {

            if (!$roles = Role::where('is_admin', User::ADMIN_USER)->get()) {
                return false;
            }

            return $roles;

        }

        if($this->tenant === User::TENANT_USER) {

            if (!$roles = Role::where('is_tenant', User::TENANT_USER)->get()) {
                return false;
            }

            return $roles;

        }

        if (!$roles = Role::all()) {
            return false;
        }

        return $roles;

    }

}
