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
        'userId',
        'userUuid',
        'description',
        'headers',
    ];

}
