<?php

namespace App\Services\User\Regular;

use App\Entities\Role;
use App\Entities\User;

class UserRegularGetAllService
{

    public function getAll()
    {

        $user = User::with('rolesUser')->first();

        $user->whereHas('rolesUser', function ($q) {
            $q->where(
                'roles',
                'elemMatch',
                [ 'name' => Role::REGULAR_USER ]
            );

        });

        return $user->paginate();

    }

}