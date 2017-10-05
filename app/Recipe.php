<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Step;
use App\Ingredient;
use App\Category;
use App\Image;

class Recipe extends Model
{
    public function steps() {
    	return $this->hasMany('App\Step');
    }

    public function ingredients() {
    	return $this->hasMany('App\Ingredient');
    }

    public function categories() {
    	return $this->belongsToMany('App\Category');
    }

    public function image() {
        return $this->morphToMany('App\Image', 'imageable');
    }
}
