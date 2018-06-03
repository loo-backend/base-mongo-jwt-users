<?php

namespace App\Services\User;

use App\Role;
use App\Services\RoleUser\CreateRoleUserService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

/**
 * Class UserCreateService
 * @package App\Services\User
 */
class UserCreateService
{

    private $admin;
    private $tenant;
    private $regular;

    private $role;
    /**
     * @var CreateRoleUserService
     */
    private $createRoleUserService;


    /**
     * UserCreateService constructor.
     * @param Role $role
     * @param CreateRoleUserService $createRoleUserService
     */
    public function __construct(Role $role,
                                CreateRoleUserService $createRoleUserService)
    {
        $this->role = $role::ADMIN_STAFF_INITIAL;
        $this->createRoleUserService = $createRoleUserService;
    }

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

    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|confirmed|min:6|max:255'
        ]);

    }

    /**
     * Create User
     *
     * @param Request $request
     * @return bool
     * @throws \Exception
     */
    public function create(Request $request)
    {

        $data = $request->all();

        if ( $request->has('roles') ) {
            $this->role = $request['roles'];
        }

        if ( $request->has('password') ) {
            $data['password'] = Hash::make($request['password']);
        }

        $data['user_uuid'] = Uuid::generate(4)->string;

        if (! $request->has('active') ) {
            $data['active'] = false;
        }

        if ($this->admin === User::ADMIN_USER) {
            $data['is_admin'] = User::ADMIN_USER;
        }

        if ($this->tenant === User::TENANT_USER) {
            $data['is_tenant'] = User::TENANT_USER;
        }

        unset($data['roles']);

        if (!$created = User::create($data) ) {
            return false;
        }

        if ($this->admin === User::ADMIN_USER) {
            $this->createRoleUserAdminInitial($created);
        } else if ($this->tenant === User::TENANT_USER) {
            $this->createRoleUserTenantAdmin($created);
        } else {
            $this->createRoleUserRegular($created);
        }

        return $created;

    }

    /**
     * @param User $user
     */
    private function createRoleUserAdminInitial(User $user)
    {
        $role = Role::where('name', Role::ADMIN_STAFF_INITIAL)->first();
        $this->createRoleUserService->create($user, $role);
    }

    /**
     * @param User $user
     */
    private function createRoleUserTenantAdmin(User $user)
    {
        $role = Role::where('name', Role::TENANT_ADMIN)->first();
        $this->createRoleUserService->create($user, $role);
    }

    /**
     * @param User $user
     */
    private function createRoleUserRegular(User $user)
    {
        $role = Role::where('name', Role::REGULAR_USER)->first();
        $this->createRoleUserService->create($user, $role);

    }

}
