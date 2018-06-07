<?php


namespace App\Services\Role;


use App\Entities\Role;

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
