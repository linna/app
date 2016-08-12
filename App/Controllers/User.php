<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use Leviu\Auth\Login;

class User extends Controller
{
    use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        parent::__construct(__CLASS__);

        $this->model = $this->loadModel();

        $this->protectController(new Login());

        $this->view->data->isLogged = $this->isLogged;
        $this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
        $this->view->data->users = $this->model->getAllUsers();

        $this->view->setTitle('App/Users');

        //load specifc css file
        $this->view->addCss('css/user.css');

        //load javascript tools
        $this->view->addJs('js/ajax.js');
        $this->view->addJs('js/dialog.js');

        //load specific js script for this controller
        $this->view->addJs('js/user.js');

        $this->view->render('User/index');
    }

    public function enable($user_id)
    {
        $this->model->enable($user_id);
    }

    public function disable($user_id)
    {
        $this->model->disable($user_id);
    }

    public function delete($user_id)
    {
        $this->model->delete($user_id);
    }

    public function changePassword($user_id)
    {
        $result = $this->model->changePassword($user_id);

        echo json_encode($result);
    }

    public function modify($user_id)
    {
        $result = $this->model->modify($user_id);

        echo json_encode($result);
    }
}
