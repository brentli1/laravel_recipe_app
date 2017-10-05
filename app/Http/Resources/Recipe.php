<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User as UserResource;

class Recipe extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'prep_time' => $this->prep_time,
            'cook_time' => $this->cook_time,
            'user_id' => $this->user_id,
            'image' => $this->image
        ];
    }
}
