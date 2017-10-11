<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class Step extends Resource
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
            'body' => $this->body,
            'image' => $this->image,
            'order' => $this->order
        ];
    }
}
