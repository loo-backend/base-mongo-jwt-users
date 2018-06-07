<?php

namespace App\Services\User;

use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class UserUpdateService
 * @package App\Services\User
 */
class UserUpdateService
{

    /**
     * Get a validator for a User Admin.
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function validator(array $data, int $id)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                Rule::unique('users', '_id')->ignore($id),
            ],
            'password' => 'sometimes|required|confirmed|min:6|max:255'
        ]);

    }

    /**
     * Remove User
     *
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function update(Request $request, $id)
    {

        if (!$user = User::find($id)) {
            return false;
        }

        $data = $request->all();

        if ($request->has('password')) {
            $data['password'] = Hash::make($request['password']);
        }

        return $user->update($data);
    }

}
