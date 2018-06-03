<?php

use App\Role;
use App\Services\RoleUser\CreateRoleUserService;
use Illuminate\Database\Seeder;
use App\User;

class UserTenantSeeder extends Seeder
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
            $this->createRoleUserTenant($user);
        });

    }

    /**
     * @param User $user
     */
    private function createRoleUserTenant(User $user)
    {
        $role = Role::where('name', Role::TENANT_ADMIN)->first();
        $this->service->create($user, $role);
    }

}
