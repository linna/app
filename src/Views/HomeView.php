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
use App\Models\HomeModel;
use App\Templates\HtmlTemplate;

/**
 * Home Page View
 */
class HomeView extends View
{
    /**
     * Constructor
     *
     * @param HomeModel $model
     * @param Login $login
     * @param HtmlTemplate $htmlTemplate
     */
    public function __construct(HomeModel $model, Login $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);
        
        //merge data passed from model with login information
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        //store html template
        $this->template = $htmlTemplate;
    }
    
    /**
     * Index
     *
     */
    public function index()
    {
        //load home html
        $this->template->loadHtml('Home');
        
        //set page title
        $this->template->title = 'App/Home';
    }
}
