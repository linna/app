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

use App\Models\LoginModel;
use App\Templates\HtmlTemplate;

class LoginView extends View
{
    public function __construct(LoginModel $model, Login $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        $this->data['loginError'] = false;
    
        $this->template = $htmlTemplate;
        
        $this->template->loadHtml('Login');
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
