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
    private $user;

    /**
     * @var array
     */
    private $role;


    public function __construct(User $user, Role $role)
    {

        $this->user = $user;
        $this->role = $role::ADMIN_STAFF_INITIAL;


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

        $data['administrator'] = $this->user::ADMIN_USER;
        unset($data['roles']);

        if (!$create = $this->user->create($data) ) {
            return false;
        }

        $create->roles()->create($this->role);

        return $create;

    }

}
