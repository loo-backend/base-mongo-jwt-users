<?php

namespace App\Entities;

use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Tenant extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'companyName',
        'limitUser',
        'databases',
        'users',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    public function databases()
    {
        return $this->embedsMany(TenantDatabase::class);
    }

    public function users()
    {
        return $this->embedsMany(User::class);
    }

    public function scopeWhereFullText($query, $search)
    {

        $query->getQuery()->projections = [
            'score' => [ '$meta'=>'textScore' ]
        ];

        return $query->whereRaw([
            '$text' => [ '$search' => $search ]
        ]);

    }

}
