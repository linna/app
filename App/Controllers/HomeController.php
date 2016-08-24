<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use App\Models\HomeModel;

class HomeController extends Controller
{
    //use \Leviu\Auth\ProtectTrait;

    public function __construct(HomeModel $model)
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
