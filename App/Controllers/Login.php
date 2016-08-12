<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use Leviu\Auth\Login as LoginClass;

class Login extends Controller
{
    use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        parent::__construct(__CLASS__);

        $this->model = $this->loadModel();

        $this->protectMethod(new LoginClass());

        $this->view->data->isLogged = $this->isLogged;
        $this->view->data->userName = $this->login->userName;

        $this->view->data->loginError = false;
    }

    public function login()
    {
        $this->view->setTitle('App/Login');

        $this->view->render('Login/index');
    }

    public function doLogin()
    {
        $login = $this->model->doLogin();

        if ($login === true) {
            header('location: '.URL);
            die();
        }

        header('location: '.URL.'loginError');
        die();
    }

    public function loginError()
    {
        $this->view->data->loginError = true;

        $this->view->setTitle('App/LoginError');

        $this->view->render('Login/index');
    }

    public function logout()
    {
        $this->model->logout();

        header('location: '.URL);
        die();
    }

    public function unauthorized()
    {
        $this->view->render('Login/unauthorized');
    }
}
