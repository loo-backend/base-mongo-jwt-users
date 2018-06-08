<?php

namespace App\Services\Auth;

use App\Events\Log\User\UserAuthenticateEvent;
use App\Entities\User;

/**
 * Class UserAuthenticateService
 * @package App\Services\User
 */
class UserAuthenticateService
{

    /**
     * @param array $data
     * @return User|bool|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function authenticate(array $data)
    {

        $user = User::with('roles');

        if (!$user = $user->where($data)->first() ) {
            return false;
        }

        event(new UserAuthenticateEvent($user));

        return $user;

    }

}
