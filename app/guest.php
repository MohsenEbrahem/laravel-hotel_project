<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class guest extends Model
{
    protected $fillable = [
		'firstName','lastName','guestRoomNumber'
	];
    public function phones(){
       return $this->hasMany(phone::class,'phoneNumberOwner','id');
    }
    public function nationalities(){
        return $this->hasMany(nationality::class,'nationalityOwner','id');
    }
}