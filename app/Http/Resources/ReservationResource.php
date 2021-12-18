<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class ReservationResource extends JsonResource
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
            'reservationId'=>$this->id,
            'guestNumber'=>$this->guestNumber,
            'roomNumber'=>$this->roomNumber,
            'incomeDate'=>$this->incomeDate,
            'exitDate'=>$this->exitDate,
            'reservationCost'=>$this->reservationCost,
            'createdAt'=>$this->created_at,
            'updatedAt'=>$this->updated_at
        ];
    }
}
