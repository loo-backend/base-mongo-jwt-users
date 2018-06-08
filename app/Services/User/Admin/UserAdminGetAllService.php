<?php

namespace App\Services\User\Admin;


use App\Entities\Role;
use App\Entities\User;

class UserAdminGetAllService
{

    public function getAll()
    {

        $user = User::with('rolesUser')->first();

        $user->whereHas('rolesUser', function ($q) {
            $q->where(
                'roles',
                'elemMatch',
                [ 'name' => Role::ADMIN ]
            );

        });

        return $user->paginate();

    }


}
