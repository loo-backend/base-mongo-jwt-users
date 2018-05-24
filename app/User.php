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

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = true;
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
        'verified',
        'verification_token',
        'roles'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token'
    ];

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    // public function setNameAttribute($name)
    // {
    //     $this->attributes['name'] = strtolower($name);
    // }

    // public function getNameAttribute($name)
    // {
    //     return ucwords($name);
    // }

//    public function setEmailAttribute($email)
//    {
//        $this->attributes['email'] = strtolower($email);
//    }

    public function isVerified()
    {
        return $this->verified == User::VERIFIED_USER;
    }

    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }

    public static function generateVerificationCode()
    {
        return str_random(40);
    }

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
