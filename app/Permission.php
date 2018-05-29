<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Permission extends Model
{

    use SoftDeletes;

    const ALL = 'ALL';
    const BROWSER = 'BROWSER';
    const READ = 'READ';
    const ADD = 'ADD';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

    protected $dates = ['deleted_at'];

}
