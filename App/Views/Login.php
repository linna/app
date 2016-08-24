<?php

namespace App\Views;

use Leviu\Mvc\AbstractView;

class Login extends AbstractView
{
    
    public function __construct()
    {
        $this->data = (object) array('isLogged'=> false, 'userName' => null, 'loginError' => false);
    }
    
    public function trowLoginError()
    {
        $this->data->loginError = true;
    }
}
