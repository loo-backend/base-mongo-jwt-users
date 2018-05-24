<?php

namespace App\Services\User;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     * @return bool|array
     */
    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if ($user) {

            $data = $request->all();

            if (isset($request->all()['password'])) {
                $data['password'] = Hash::make($request->all()['password']);
            }

            $user->update($data);
        }

        return $user;
    }

}