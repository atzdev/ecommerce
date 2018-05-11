<?php

namespace App\Exceptions;

use Exception;

class ReviewNotBelongsToUser extends Exception
{
    public function render()
    {
    	return ['errors' => 'Review Not Belongs to User'];
    }
}
