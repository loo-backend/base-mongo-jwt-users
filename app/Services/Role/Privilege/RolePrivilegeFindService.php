<?php

namespace App\Services\Role\Privilege;

use App\Privilege;

/**
 * Class RolePrivilegeFindService
 * @package App\Services\Role
 */
class RolePrivilegeFindService
{

    /**
     * @param $id
     * @return bool
     */
    public function findBy($id)
    {

        if(!$privilege = Privilege::find($id)) {
            return false;
        }

        return $privilege;

    }

}
