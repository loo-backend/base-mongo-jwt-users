<?php

namespace App\Services\Adm\User\Regular;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class UpdateUserRegularService
{

    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get a validator for a User.
     *
     * @param array $data
     * @param int $id
     * @return mixed
     */
    public function validator(array $data, $id)
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
     * Update User
     *
     * @param Request $request
     * @param $id
     * @return bool
     */
    public function update(Request $request, $id)
    {

        $data = $request->all();
        if ($request->has('password')) {
            $data['password'] = Hash::make($request['password']);
        }

        return $this->repository->update($id, $data);

    }

}
