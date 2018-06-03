<?php

use App\Role;
use Illuminate\Database\Seeder;
use App\User;
use App\Services\RoleUser\CreateRoleUserService;


class UserRegularSeeder extends Seeder
{

    /**
     * @var CreateRoleUserService
     */
    private $service;

    /**
     * UserRegularSeeder constructor.
     * @param CreateRoleUserService $service
     */
    public function __construct(CreateRoleUserService $service)
    {
        $this->service = $service;
    }

    public function run()
    {

        $users = factory(User::class,5)->create();
        $users->each(function ($user) {
            $this->createRoleUserRegular($user);
        });

    }

    /**
     * @param User $user
     */
    private function createRoleUserRegular(User $user)
    {
        $role = Role::where('name', Role::REGULAR_USER)->first();
        $this->service->create($user, $role);
    }

}
