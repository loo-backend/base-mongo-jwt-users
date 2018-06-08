<?php

namespace App\Services\User\Tenant;

use App\Entities\Role;
use App\Entities\User;

class UserTenantGetAllService
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserAdminGetAllService constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getAll()
    {

        $user = $this->user->whereIn(
            'roles.name',
            [
                Role::TENANT_ADMIN,
                Role::TENANT_EDITOR,
                Role::TENANT_EXPEDITION,
                Role::TENANT_PARTNER
            ]
        );

        return $user->paginate();

    }

}
