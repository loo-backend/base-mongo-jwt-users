<?php

namespace App\Services\User\Admin;

use App\User;

/**
 * Class UserAdminAllService
 * @package App\Services\User\Admin
 */
class UserAdminAllService
{

    /**
     * All Users Admin
     *
     * @return bool|array
     */
    public function all()
    {

        $user = User::where('administrator', User::ADMIN_USER)
                        ->paginate();

        if (!$user) {
            return false;
        }

        return $user;

    }

}
