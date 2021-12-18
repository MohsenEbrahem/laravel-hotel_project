<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nationality extends Model
{
    protected $fillable=[
        'nationality',
        'nationalityOwner'
    ];
}
