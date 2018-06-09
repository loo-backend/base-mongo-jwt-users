<?php

namespace App\Services\Adm\User\Admin;

use App\Entities\Role;
use App\Entities\User;
use App\Services\Role\RoleGenerateToUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;


class UserAdminCreateService
{

    /**
     * @var RoleGenerateToUserService
     */
    private $generateToUserService;
    /**
     * @var Role
     */
    private $role;

    /**
     * UserAdminCreateService constructor.
     * @param RoleGenerateToUserService $generateToUserService
     * @param Role $role
     */
    public function __construct(RoleGenerateToUserService $generateToUserService,
                                Role $role)
    {
        $this->generateToUserService = $generateToUserService;
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

        $this->generateToUserService->generateRole(
            $created,
            Role::ADMIN_STAFF_INITIAL
        );

        return $created;

    }

}
