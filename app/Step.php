<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Recipe;
use App\Image;

class Step extends Model
{
    public function recipe() {
    	return $this->belongsTo('App\Recipe');
    }

    public function images() {
        return $this->morphToMany('App\Image', 'imageable');
    }
}
