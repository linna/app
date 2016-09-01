<?php

namespace App\Views;

use Linna\Mvc\View;
use Linna\Auth\Login;

use App\Models\LoginModel;
use App\Templates\HtmlTemplate;

class LoginView extends View
{
    public function __construct(LoginModel $model)
    {
        parent::__construct($model);
        
        $login = new Login();
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        $this->data['loginError'] = false;
    
        $this->template = new HtmlTemplate('Login');
    }
    
    public function index()
    {
        $this->template->title = 'App/Login';
    }
    
    public function doLogin()
    {
        $this->template->title = 'App/LoginError';
    }
}
