<?php

namespace App\Entities\Role;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;

    const ADMIN                  = 'ADMIN';
    const ADMIN_STAFF_AUDIT      = 'ADMIN_STAFF_AUDIT';
    const ADMIN_STAFF_SUPPORT    = 'ADMIN_STAFF_SUPPORT';
    const ADMIN_STAFF_FINANCE    = 'ADMIN_STAFF_FINANCE';
    const ADMIN_STAFF_COMMERCIAL = 'ADMIN_STAFF_COMMERCIAL';
    const ADMIN_STAFF_INITIAL    = 'ADMIN_STAFF_INITIAL';
    const TENANT_ADMIN           = 'TENANT_ADMIN';
    const TENANT_EDITOR          = 'TENANT_EDITOR';
    const TENANT_EXPEDITION      = 'TENANT_EXPEDITION';
    const TENANT_PARTNER         = 'TENANT_PARTNER';
    const REGULAR_USER           = 'REGULAR_USER';

    public $table = 'roles';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'default',
        'privileges'
    ];

    protected $dates = ['deleted_at'];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function privileges()
    {
        return $this->embedsMany(Privilege::class);
    }

}
