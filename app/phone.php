<?php

namespace App;
use App\guest;
use Illuminate\Database\Eloquent\Model;

class phone extends Model
{
    protected $fillable=[
        'phoneNumber',
        'phoneNumberOwner'
    ];
    public function guest(){
        return $this->belongsTo(guest::class,'phoneNumberOwner','id');
    }
}
