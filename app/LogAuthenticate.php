<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class LogAuthenticate extends Model
{
    use SoftDeletes;

    protected $connection = 'mainlog';

    protected $fillable = [
        'action',
        'user_id',
        'user_uuid',
        'description',
        'headers',
    ];

}
