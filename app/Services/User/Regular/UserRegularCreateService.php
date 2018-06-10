<?php

namespace App\Services\User\Regular;

use App\Entities\Role;
use App\Entities\User;
use App\Services\Role\RoleGenerateToUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

/**
 * Class UserRegularCreateService
 * @package App\Services\User\Regular
 */
class UserRegularCreateService
{

    /**
     * @var RoleGenerateToUserService
     */
    private $generateToUserService;

    /**
     * UserAdminCreateService constructor.
     * @param RoleGenerateToUserService $generateToUserService
     */
    public function __construct(RoleGenerateToUserService $generateToUserService)
    {
        $this->generateToUserService = $generateToUserService;
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
            $created, Role::REGULAR_USER
        );

        return $created;

    }

}
