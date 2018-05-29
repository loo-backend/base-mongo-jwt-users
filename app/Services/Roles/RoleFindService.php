<?php


namespace App\Services\Roles;


use App\Role;

/**
 * Class RoleFindService
 * @package App\Services\Roles
 */
class RoleFindService
{

    /**
     * @param $id
     * @return bool
     */
    public function findBy($id)
    {

        if(!$role = Role::find($id)) {
            return false;
        }

        return $role;

    }

}
