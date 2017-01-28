<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

namespace App\Views;

use Linna\Mvc\View;
use Linna\Auth\Login;
use App\Models\LoginModel;
use App\Templates\HtmlTemplate;

/**
 * Login View
 */
class LoginView extends View
{
    /**
     * Constructor
     *
     * @param LoginModel $model
     * @param Login $login
     * @param HtmlTemplate $htmlTemplate
     */
    public function __construct(LoginModel $model, Login $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);
        
        //merge data passed from model with login information
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        //store value for show error messages in login html template
        $this->data['loginError'] = false;
        
        //store html template
        $this->template = $htmlTemplate;
        
        //load login html
        $this->template->loadHtml('Login');
        //load login css
        $this->template->loadCss('css/login.css');
    }
    
    /**
     * Login page index
     */
    public function index()
    {
        //set page title
        $this->template->title = 'App/Login';
    }
    
    /**
     * Login error page index
     * Change only page title :)
     */
    public function doLogin()
    {
        //set page title
        $this->template->title = 'App/LoginError';
    }
}
