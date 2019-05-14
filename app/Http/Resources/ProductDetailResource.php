<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductDetailResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'guid' => $this->guid,
            'title' => $this->title,
            'thumb' => $this->thumb,
            'thumb_desc' => $this->thumb_desc,
            'desc' => $this->detail->desc,
            'img' => $this->detail->img,
        ];
    }
}
