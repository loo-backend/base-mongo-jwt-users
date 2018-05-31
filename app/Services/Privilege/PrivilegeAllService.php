<?php

namespace App\Services\Privilege;

use App\Privilege;

/**
 * Class PrivilegeAllService
 * @package App\Services\Role\Privilege
 */
class PrivilegeAllService
{

    public function all()
    {

        if (!$privileges = Privilege::all()) {
            return false;
        }

        return $privileges;
    }

}
