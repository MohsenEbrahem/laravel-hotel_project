<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PhoneResource extends JsonResource
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
            'phoneId'=>$this->id,
            'phoneNumber'=>$this->phoneNumber,
            'phoneNumberOwner'=>$this->phoneNumberOwner,
            'createdAt'=>$this->created_at,
            'updatedAt'=>$this->updated_at
        ];
    }
}
