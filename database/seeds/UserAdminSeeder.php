<?php

use App\Role;
use App\Services\RoleUser\CreateRoleUserService;
use App\User;
use Illuminate\Database\Seeder;

class UserAdminSeeder extends Seeder
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

        $users = factory(User::class,5)->create([
            'is_admin' => User::ADMIN_USER
        ]);

        $users->each(function ($user) {
            $this->createRoleUserAdmin($user);
        });

    }

    /**
     * @param User $user
     */
    private function createRoleUserAdmin(User $user)
    {
        $role = Role::where('name', Role::ADMIN)->first();
        $this->service->create($user, $role);
    }

}
