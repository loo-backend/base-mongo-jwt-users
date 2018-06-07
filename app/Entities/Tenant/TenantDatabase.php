<?php

namespace App\Entities\Tenant;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class TenantDatabase extends Model
{
    use SoftDeletes;

    protected $table = 'databases';

    protected $fillable = [
        'driver',
        'port',
        'hostname',
        'database_name',
        'user_name',
        'password',
        'options',
    ];

    protected $dates = ['deleted_at'];

}
