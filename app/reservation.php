<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class reservation extends Model
{
    protected $fillable=[
        'guestNumber','roomNumber','incomeDate','exitDate','reservationCost'
    ];
}
