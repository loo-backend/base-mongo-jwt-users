<?php

namespace App\Services\Role;

use App\Composite\UserRoleComposite;
use App\Entities\Role;
use App\Entities\User;

/**
 * Class RoleService
 * @package App\Services\Role
 */
class RoleService extends UserRoleComposite
{


    public function all()
    {

        if($this->admin === User::ADMIN_USER) {

            if (!$roles = Role::whereIn('name', [

                Role::ADMIN,
                Role::ADMIN_STAFF_AUDIT,
                Role::ADMIN_STAFF_SUPPORT,
                Role::ADMIN_STAFF_FINANCE,
                Role::ADMIN_STAFF_COMMERCIAL,
                Role::ADMIN_STAFF_INITIAL,

            ])->get()) {
                return false;
            }

            return $roles;

        }

        if($this->tenant === User::TENANT_USER) {

            if (!$roles = Role::whereIn('name', [

                Role::TENANT_ADMIN,
                Role::TENANT_EDITOR,
                Role::TENANT_EXPEDITION,
                Role::TENANT_PARTNER,

            ])->get()) {
                return false;
            }

            return $roles;

        }

        if($this->tenant === User::REGULAR_USER) {

            if (!$roles = Role::whereIn('name', [
                Role::REGULAR_USER,
            ])->get()) {
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
