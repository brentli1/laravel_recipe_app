<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;

/**
 * Ingredient Model
 * 
 * PHP version 7.1.9
 */
class Ingredient extends Model
{
    /**
     * Fetch recipe relation
     * 
     * @return array
     */
    public function recipe() {
    	return $this->belongsTo('App\Recipe');
    }
}
