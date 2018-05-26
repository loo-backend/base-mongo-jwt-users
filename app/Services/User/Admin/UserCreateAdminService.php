<?php

namespace App\Services\User\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Webpatser\Uuid\Uuid;

/**
 * Class UserCreateAdminService
 * @package App\Services\User\Admin
 */
class UserCreateAdminService
{


    /**
     * @var array
     */
    private $roles;

    /**
     * UserCreateAdminService constructor.
     */
    public function __construct()
    {
        $this->roles = Role::ADMIN_STAFF_INITIAL;
    }


    /**
     * Get a validator for a User Admin.
     *
     * @param array $data
     * @return mixed
     */
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

        if (!empty($request['roles'])) {
            $this->roles = $request['roles'];
        }

        $data['password'] = Hash::make($request->all()['password']);
        $data['user_uuid'] = Uuid::generate(4)->string;

        if (!isset($request['active'])) {
            $data['active'] = false;
        }

        $data['administrator'] = true;
        unset($data['roles']);

        if (!$create = User::create($data) ) {
            return false;
        }

        $create->roles()->create($this->roles);

        return $create;

    }

}
