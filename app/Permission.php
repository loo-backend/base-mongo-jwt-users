<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Permission extends Model
{
    const ALL = 'ALL';
    const BROWSER = 'BROWSER';
    const READ = 'READ';
    const ADD = 'ADD';
    const EDIT = 'EDIT';
    const DELETE = 'DELETE';

}
