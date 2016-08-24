<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use Leviu\Auth\Login as LoginTool;

use App\Views\Login as LoginView;
use App\Templates\HtmlTemplate as LoginTemplate;
use App\Models\Login as LoginModel;

class _Login extends Controller
{
    //use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        //parent::__construct(__CLASS__);

        //$this->model = $this->loadModel();
        $this->model = new LoginModel;
        //$this->protectMethod(new LoginClass());

        //$this->view->data->isLogged = $this->isLogged;
        //$this->view->data->userName = $this->login->userName;

        //$this->view->data->loginError = false;
    }

    public function login()
    {
        $template = new LoginTemplate('Login');
        $template->title = 'App/Login';
        
        $view = new LoginView();
        $view->render($template);

        //$this->view->setTitle('App/Login');

        //$this->view->render('Login');
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
        //$this->view->data->loginError = true;

        //$this->view->setTitle('App/LoginError');

        //$this->view->render('Login');

        $template = new LoginTemplate('Login');
        $template->title = 'App/LoginError';
        
        $view = new LoginView();
        $view->trowLoginError();
        $view->render($template);
    }

    public function logout()
    {
        $this->model->logout();

        header('location: '.URL);
        die();
    }

    public function unauthorized()
    {
        $this->view->render('Unauthorized');
    }
}
