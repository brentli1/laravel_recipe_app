<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Recipe;
use App\Image;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    public function recipes() {
        return $this->hasMany('App\Recipe');
    }

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
