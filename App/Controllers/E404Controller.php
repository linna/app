<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use App\Models\E404Model;


class E404Controller extends Controller
{
    //use \Leviu\Auth\ProtectTrait;

    public function __construct(E404Model $model)
    {
        parent::__construct($model);

        //$this->protectMethod(new Login());

        //$this->view->data->isLogged = $this->isLogged;
        //$this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
       
    }
}
