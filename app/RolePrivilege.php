<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class RolePrivilege extends Model
{

    use SoftDeletes;

    const ALL     = 'ALL';
    const BROWSER = 'BROWSER';
    const READ    = 'READ';
    const ADD     = 'ADD';
    const EDIT    = 'EDIT';
    const DELETE  = 'DELETE';

    public $table = 'privileges';

    protected $fillable = [
        'name',
        'description',
        'privilege_uuid'
    ];

    protected $dates = ['deleted_at'];

}
