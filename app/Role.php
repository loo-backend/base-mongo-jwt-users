<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Role extends Model
{

    const ADMINISTRATOR =
        [
            'name' => 'ADMINISTRATOR',
            'permissions' => [
                Permission::ALL,
            ]
        ];

    const ADMIN_STAFF_INITIAL =
        [
            'name' => 'ADMIN_STAFF_INITIAL',
            'permissions' => [
                Permission::BROWSER,
                Permission::READ,
            ]
        ];

    const ADMIN_STAFF_SUPPORT =
        [
            'name' => 'ADMIN_STAFF_SUPPORT',
            'permissions' => [
                Permission::READ,
                Permission::ADD,
                Permission::EDIT,
            ]
        ];

    const ADMIN_STAFF_FINANCE =
        [
            'name' => 'ADMIN_STAFF_FINANCE',
            'permissions' => [
                Permission::READ,
                Permission::ADD,
                Permission::EDIT,
            ]
        ];

    const ADMIN_STAFF_COMMERCIAL =
        [
            'name' => 'ADMIN_STAFF_COMMERCIAL',
            'permissions' => [
                Permission::READ,
                Permission::ADD,
                Permission::EDIT,
            ]
        ];

    const TENANT_ADMINISTRATOR =
        [
            'name' => 'TENANT_ADMINISTRATOR',
            'permissions' => [
                Permission::ALL,
            ]
        ];

    const TENANT_EDITOR =
        [
            'name' => 'TENANT_EDITOR',
            'permissions' => [
                Permission::READ,
                Permission::ADD,
                Permission::EDIT,
            ]
        ];

    const TENANT_DEVELOP =
        [
            'name' => 'TENANT_DEVELOP',
            'permissions' => [
                Permission::READ,
                Permission::ADD,
                Permission::EDIT,
            ]
        ];


    public $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'role_uuid'
    ];




    public function users()
    {
        return $this->belongsToMany(User::class, null, 'role_ids', 'user_ids');
    }

}
