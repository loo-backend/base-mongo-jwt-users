<?php

namespace App\Services\User;

use App\User;

class UserRemoveService
{

    /**
     * Remove User
     *
     * @param $id
     * @return bool|array
     */
    public function remove($id)
    {

        if (!$user = User::find($id) ) {
            return false;
        }

        return $user->delete();

    }

}
