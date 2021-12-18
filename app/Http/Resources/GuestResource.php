<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PhoneResource;
use App\Phone;
use App\Nationality;
class GuestResource extends JsonResource
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
            'guestNumber'=>$this->id,
            'firstName'=>$this->firstName,
            'lastName'=>$this->lastName,
            'guestRoomNumber'=>$this->guestRoomNumber,
            'guestPhoneNumbers'=>PhoneResource::collection(Phone::all()->where('phoneNumberOwner','=',$this->id)),
            'guestNationality'=>NationalityResource::collection(Nationality::all()->where('nationalityOwner','=',$this->id)),
            'createdAt'=>$this->created_at,
            'updatedAt'=>$this->updated_at
        ];
    }
}
