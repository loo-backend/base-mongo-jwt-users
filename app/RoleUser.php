<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class RoleUser extends Model
{

    public $table = 'role_users';

    protected $fillable = [
        'user_uuid',
        'roles'
    ];

    public function roles()
    {
        return $this->embedsMany(Role::class);
    }

}
