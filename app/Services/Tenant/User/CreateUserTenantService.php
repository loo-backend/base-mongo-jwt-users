<?php

namespace App\Services\Tenant\User;

use App\Entities\Role;
use App\Entities\User;
use App\Factories\GenerateRoleUserFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;


class CreateUserTenantService
{

    /**
     * @var GenerateRoleUserFactory
     */
    private $generateRoleUserFactory;

    /**
     * @var Role
     */
    private $role;

    /**
     * CreateUserAdminService constructor.
     * @param GenerateRoleUserFactory $generateRoleUserFactory
     * @param Role $role
     */
    public function __construct(GenerateRoleUserFactory $generateRoleUserFactory,
        Role $role)
    {
        $this->generateRoleUserFactory = $generateRoleUserFactory;
        $this->role = $role;
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

        if ($request->has('roles')) {
            $this->role = $request['roles'];
        } else {
            $this->role = Role::TENANT_ADMIN;
        }

        if ($request->has('password')) {
            $data['password'] = Hash::make($request['password']);
        }

        $data['userUuid'] = Uuid::generate(4)->string;

        if (!$request->has('active')) {
            $data['active'] = false;
        }

        unset($data['roles']);

        if (!$created = User::create($data)) {
            return false;
        }

        $this->generateRoleUserFactory->generate(
            $created,
            $this->role
        );

        return $created;

    }

}
