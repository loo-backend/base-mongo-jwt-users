<?php

namespace App\Entities\Log;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class LogUser extends Model
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
