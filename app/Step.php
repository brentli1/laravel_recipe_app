<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;
use App\Image;

/**
 * Step Model
 * 
 * PHP version 7.1.9
 */
class Step extends Model
{
    /**
     * Fetch step recipe relation
     * 
     * @return array
     */
    public function recipe() {
    	return $this->belongsTo('App\Recipe');
    }

    /**
     * Fetch step images
     * 
     * @return array
     */
    public function image() {
        return $this->morphToMany('App\Image', 'imageable');
    }
}
