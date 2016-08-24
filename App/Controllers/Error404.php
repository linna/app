<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use App\Views\Home as Error404View;
use App\Templates\HtmlTemplate as Error404Template;

class Error404 extends Controller
{
    //use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        //parent::__construct(__CLASS__);

        //$this->protectMethod(new Login());

        //$this->view->data->isLogged = $this->isLogged;
        //$this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
        $template = new Error404Template('Error404');
        $template->title = 'App/Error404';
        
        $view = new Error404View();
        $view->render($template);
    }
}
