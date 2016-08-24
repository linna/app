<?php

namespace App\Views;

use Leviu\Mvc\View;
use App\Models\UserModel;
use App\Templates\HtmlTemplate;
use App\Templates\JsonAjaxTemplate;

class UserView extends View
{
    
    public function __construct(UserModel $model)
    {
        parent::__construct($model);
    }
    
    public function index()
    {
        //template configuration
        $this->template = new HtmlTemplate('User');
        
        $this->template->loadCss('css/user.css');

        //load javascript tools
        $this->template->loadJs('js/ajax.js');
        $this->template->loadJs('js/dialog.js');

        //load specific js script for this controller
        $this->template->loadJs('js/user.js');
        
        $this->template->title = 'App/User';
        
        $this->data = (object) array('isLogged'=> false, 'userName' => null);
        $this->data->users = $this->model->getAllUsers();
    }
    
    public function enable()
    {
        $this->template = new JsonAjaxTemplate();
        //$this->data = 0;
    }

    public function disable()
    {
        $this->template = new JsonAjaxTemplate();
        //$this->data = 0;
    }

    public function delete()
    {
        $this->template = new JsonAjaxTemplate();
        //$this->data = 0;
    }

    public function changePassword()
    {
        $this->template = new JsonAjaxTemplate();
        //$this->data = $this->notifiedData;
    }

    public function modify()
    {
        $this->template = new JsonAjaxTemplate();
        //$this->data = $this->notifiedData;
    }
}
