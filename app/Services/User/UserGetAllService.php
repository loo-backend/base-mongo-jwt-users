<?php

namespace App\Services\User;

use App\Composite\UserRoleComposite;
use App\Entities\User;
use App\Repositories\User\UserRepositoryInterface;

/**
 * Class UserIndexService
 * @package App\Services\User
 */
class UserGetAllService extends UserRoleComposite
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * UserIndexService constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {

        if ($this->admin) {

            if (!$user = User::where('isAdmin', User::ADMIN_USER)->paginate()) {
                return false;
            }

            return $user;
        }

        if ($this->tenant === User::TENANT_USER) {

            if (!$user = User::paginate()) {
                return false;
            }

            return $user;
        }

        if ($this->regular === User::REGULAR_USER) {

            if (!$user = User::paginate()) {
                return false;
            }

            return $user;
        }

        if (!$user = User::paginate()) {
            return false;
        }

    }

}
