<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2016, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

namespace App\Views;

use Linna\Mvc\View;
use Linna\Auth\Login;

use App\Models\UserModel;
use App\Templates\HtmlTemplate;
use App\Templates\JsonAjaxTemplate;

class UserView extends View
{
    public function __construct(UserModel $model)
    {
        parent::__construct($model);
        
        $login = new Login();
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
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
        
        $this->data['users'] = $this->model->getAllUsers();
    }
    
    public function enable()
    {
        $this->template = new JsonAjaxTemplate();
    }

    public function disable()
    {
        $this->template = new JsonAjaxTemplate();
    }

    public function delete()
    {
        $this->template = new JsonAjaxTemplate();
    }

    public function changePassword()
    {
        $this->template = new JsonAjaxTemplate();
    }

    public function modify()
    {
        $this->template = new JsonAjaxTemplate();
    }
}
