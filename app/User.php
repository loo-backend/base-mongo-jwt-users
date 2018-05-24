<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;


/**
 * Class User
 * @package App
 */
class User extends Authenticatable implements JWTSubject
{

    use SoftDeletes, Notifiable;

    const ADMINISTRATOR_USER = true;

    const REGULAR_USER = false;

    /**
     * @var string
     */
    public $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'name',
        'email',
        'password',
        'remember_token',
        'administrator',
        'active',
        'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function roles()
    {
        return $this->embedsMany(Role::class);
    }

}
