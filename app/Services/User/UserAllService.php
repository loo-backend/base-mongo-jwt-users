<?php

namespace App\Services\User;

use App\User;

/**
 * Class UserAllService
 * @package App\Services\User
 */
class UserAllService
{

    private $admin;
    private $tenant;
    private $regular;

    public function admin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

    public function tenant($tenant)
    {
        $this->tenant = $tenant;
        return $this;
    }

    public function regular($regular)
    {
        $this->regular = $regular;
        return $this;
    }

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
