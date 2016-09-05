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
use Linna\Session\Session;

use App\Models\LoginModel;
use App\Templates\HtmlTemplate;

class LoginView extends View
{
    public function __construct(LoginModel $model)
    {
        parent::__construct($model);
        
        $login = new Login(Session::getInstance());
        
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
