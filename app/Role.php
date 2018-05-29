<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;

    const ADMINISTRATOR          = 'ADMINISTRATOR';
    const ADMIN_STAFF_SUPPORT    = 'ADMIN_STAFF_SUPPORT';
    const ADMIN_STAFF_FINANCE    = 'ADMIN_STAFF_FINANCE';
    const ADMIN_STAFF_COMMERCIAL = 'ADMIN_STAFF_COMMERCIAL';
    const ADMIN_STAFF_INITIAL    = 'ADMIN_STAFF_INITIAL';
    const TENANT_ADMINISTRATOR   = 'TENANT_ADMINISTRATOR';
    const TENANT_EDITOR          = 'TENANT_EDITOR';
    const TENANT_DEVELOP         = 'TENANT_DEVELOP';
    const TENANT_PARTNER         = 'TENANT_PARTNER';

    public $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'administrator',
        'role_uuid',
        'default'
    ];

    protected $dates = ['deleted_at'];


    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function privilege()
    {
        return $this->embedsMany(Privilege::class);
    }

}
