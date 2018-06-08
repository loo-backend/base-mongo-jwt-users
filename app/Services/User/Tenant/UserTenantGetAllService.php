<?php

namespace App\Services\User\Tenant;

use App\Entities\Role;
use App\Entities\User;

class UserTenantGetAllService
{

    public function getAll()
    {

        $user = User::with('rolesUser')->first();

        $user->whereHas('rolesUser', function ($q) {
            $q->where(
                'roles',
                'elemMatch',
                [ 'name' => Role::TENANT_ADMIN ]
            );

        });

        return $user->paginate();

    }

}
