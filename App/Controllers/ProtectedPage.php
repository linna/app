<?php

namespace App\Controllers;

use Leviu\Routing\Controller;
use Leviu\Auth\Login;

class ProtectedPage extends Controller
{
    use \Leviu\Auth\ProtectTrait;
    
    public function __construct()
    {
        parent::__construct(__CLASS__);
        
        $this->protectController(new Login());
       
        $this->view->data->isLogged = $this->isLogged;
        $this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
        $this->view->setTitle('App/ProtectedPage');
        
        $this->view->render('ProtectedPage/index');
    }
}