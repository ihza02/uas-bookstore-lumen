<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    /**
     * JWT Implementation
     * Get the identifier that will be stored in the subject claim of the JWT
     * 
     * @return mixed
     */
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    /** 
     * Return a key value array, contraining any custom claims to be added to the JWT
     * 
     * @return array
     */
    public function getJWTCustomClaims(){
        return [];
    }

    /** ==== Realationship ==== */
    public function books () {
        return $this->hasMany(Book::class);
    }

    public function transactions () {
        return $this->hasMany(Transaction::class);
    }
}
