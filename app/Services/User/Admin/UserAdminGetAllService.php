<?php

namespace App\Services\User\Admin;


use App\Entities\Role;
use App\Entities\User;

class UserAdminGetAllService
{

    public function getAll()
    {

        $user = User::with('roles')->first();

        $user->whereHas('roles', function ($q) {
            $q->where(
                'roles',
                'elemMatch',
                [ 'name' => Role::ADMIN ]
            );

        });

        return $user->paginate();

    }


}
