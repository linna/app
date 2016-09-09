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
use App\Templates\JsonTemplate;

class UserView extends View
{
    private $htmlTemplate;
    
    private $jsonTemplate;
    
    public function __construct(UserModel $model, Login $login, HtmlTemplate $htmlTemplate, JsonTemplate $jsonTemplate)
    {
        parent::__construct($model);
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        $this->htmlTemplate = $htmlTemplate;
        $this->jsonTemplate = $jsonTemplate; 
    }
    
    public function index()
    {
        //template configuration
        $this->template = $this->htmlTemplate;
        
        $this->template->loadHtml('User');
        
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
        $this->template = $this->jsonTemplate;
    }

    public function disable()
    {
        $this->template = $this->jsonTemplate;
    }

    public function delete()
    {
        $this->template = $this->jsonTemplate;
    }

    public function changePassword()
    {
        $this->template = $this->jsonTemplate;
    }

    public function modify()
    {
        $this->template = $this->jsonTemplate;
    }
}
