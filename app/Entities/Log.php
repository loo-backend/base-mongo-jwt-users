<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Log extends Model
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
