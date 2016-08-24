<?php

namespace App\Views;

use Leviu\Mvc\AbstractView;

class Error404 extends AbstractView
{
    
    public function __construct()
    {
        $this->data = (object) array('isLogged'=> false, 'userName' => null);
    }
}
