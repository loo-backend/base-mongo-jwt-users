<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use App\User;

class Tenant extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'tenant_uuid',
        'company_name'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function roles()
    {
        return $this->belongsToMany('Role', null, 'user_ids', 'role_ids');
    }

}
