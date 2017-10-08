<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;

/**
 * Category Model
 * 
 * PHP version 7.1.9
 */
class Category extends Model
{
    /**
     * Fetch recipes relations
     * 
     * @return array
     */
    public function recipes() {
    	return $this->belongsToMany('App\Recipe');
    }
}
