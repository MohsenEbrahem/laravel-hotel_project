<?php

namespace App\Exceptions;

use Exception;

class NotFoundRecord extends Exception
{

   
    public function render()
    {
       return response(['message'=>'NotFoundRecord'], 404);
    }
}
