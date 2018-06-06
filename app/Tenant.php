<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use App\User;

class Tenant extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'companyName'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

}
