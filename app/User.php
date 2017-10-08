<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Recipe;
use App\Image;

/**
 * User Model
 * 
 * PHP version 7.1.9
 */
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * Fetch user recipes relations
     * 
     * @return array
     */
    public function recipes() {
        return $this->hasMany('App\Recipe');
    }

    /**
     * Fetch user profile image relation
     * 
     * @return array
     */
    public function image() {
        return $this->morphToMany('App\Image', 'imageable');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
