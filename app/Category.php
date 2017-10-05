<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;

class Category extends Model
{
    public function recipes() {
    	return $this->belongsToMany('App\Recipe');
    }
}
