<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use App\Views\User as UserView;
use App\Templates\HtmlTemplate as UserTemplate;
use App\Models\User as UserModel;

class User extends Controller
{
    //use \Leviu\Auth\ProtectTrait;

    public function __construct()
    {
        //parent::__construct(__CLASS__);

        $this->model = new UserModel;

        //$this->protectController(new Login(), URL.'unauthorized');

        //$this->view->data->isLogged = $this->isLogged;
        //$this->view->data->userName = $this->login->userName;
    }

    public function index()
    {
        $template = new UserTemplate('User');
        $template->title = 'App/User';
        
        //load css for UserTemplate
        $template->loadCss('css/user.css');

        //load javascript tools
        $template->loadJs('js/ajax.js');
        $template->loadJs('js/dialog.js');

        //load specific js script for this controller
        $template->loadJs('js/user.js');
        
        
        $view = new UserView();
        $view->showAllUser();
        $view->render($template);
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
