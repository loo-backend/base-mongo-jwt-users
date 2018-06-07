<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Tenant extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'companyName',
        'limitUser',
        'databases',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function databases()
    {
        return $this->embedsMany(TenantDatabase::class);
    }

}
