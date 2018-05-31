<?php

namespace App\Services\Privilege;

use App\Privilege;

/**
 * Class PrivilegeFindService
 * @package App\Services\Role\Privilege
 */
class PrivilegeFindService
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
