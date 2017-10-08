<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Step;
use App\Ingredient;
use App\Category;
use App\Image;

/**
 * Recipe Model
 * 
 * PHP version 7.1.9
 */
class Recipe extends Model
{
    /**
     * Fetch recipe steps relations
     * 
     * @return array
     */
    public function steps() {
    	return $this->hasMany('App\Step');
    }

    /**
     * Fetch recipe ingredients relations
     * 
     * @return array
     */
    public function ingredients() {
    	return $this->hasMany('App\Ingredient');
    }

    /**
     * Fetch recipe categories relations
     * 
     * @return array
     */
    public function categories() {
    	return $this->belongsToMany('App\Category');
    }

    /**
     * Fetch recipe image relations
     * 
     * @return array
     */
    public function image() {
        return $this->morphToMany('App\Image', 'imageable');
    }
}
