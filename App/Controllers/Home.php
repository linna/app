<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use Leviu\Auth\Login;

class Home extends Controller
{
    use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        parent::__construct(__CLASS__);

        $this->protectMethod(new Login());

        $this->view->data->isLogged = $this->isLogged;
        $this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
        $this->view->setTitle('App/Home');

        $this->view->render('Home/index');
    }
}
