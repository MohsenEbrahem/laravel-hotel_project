<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class NationalityResource extends JsonResource
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
            'nationalityId'=>$this->id,
            'nationality'=>$this->nationality,
            'nationalityOwnerNumber'=>$this->nationalityOwner,
            'createdAt'=>$this->created_at,
            'updatedAt'=>$this->updated_at
        ];
    }
}
