<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MessaageResource extends JsonResource
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
            'id'=>$this->id,
            'from'=>$this->from,
            'to'=>$this->to,
            'text'=>$this->text,
            'sentAt'=>$this->created_at->format('d M H:i')
        ];
    }
}
