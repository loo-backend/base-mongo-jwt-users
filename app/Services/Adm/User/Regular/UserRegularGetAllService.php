<?php

namespace App\Services\Adm\User\Regular;

use App\Entities\Role;
use App\Entities\User;

/**
 * Class UserRegularGetAllService
 * @package App\Services\Adm\User\Regular
 */
class UserRegularGetAllService
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
                Role::REGULAR_USER
            ]
        );

        return $user->paginate();

    }

}
