<?php

namespace App\Services\Adm\User\Admin;

use App\Entities\Role;
use App\Entities\User;

/**
 * Class GetAllUserAdminService
 * @package App\Services\Adm\User\Admin
 */
class GetAllUserAdminService
{
    /**
     * @var User
     */
    private $user;

    /**
     * GetAllUserAdminService constructor.
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

                Role::ADMIN,
                Role::ADMIN_STAFF_AUDIT,
                Role::ADMIN_STAFF_SUPPORT,
                Role::ADMIN_STAFF_FINANCE,
                Role::ADMIN_STAFF_COMMERCIAL,
                Role::ADMIN_STAFF_INITIAL,

            ]
        );

        return $user->paginate();

    }

}
