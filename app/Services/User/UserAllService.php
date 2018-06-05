<?php

namespace App\Services\User;

use App\Composite\UserRoleComposite;
use App\User;

/**
 * Class UserAllService
 * @package App\Services\User
 */
class UserAllService extends UserRoleComposite
{

    public function all()
    {


        if ($this->admin === User::ADMIN_USER) {

            if (!$user = User::where('is_admin', User::ADMIN_USER)->paginate()) {
                return false;
            }

            return $user;
        }


        if ($this->tenant === User::TENANT_USER) {

            if (!$user = User::where('is_tenant', User::TENANT_USER)->paginate()) {
                return false;
            }

            return $user;
        }


        if ($this->regular === User::REGULAR_USER) {

            if (!$user = User::whereNull('is_admin')->whereNull('is_tenant')->paginate()) {
                return false;
            }

            return $user;
        }

        if (!$user = User::paginate()) {
            return false;
        }

    }

}
