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

use App\Models\HomeModel;
use App\Templates\HtmlTemplate;

class HomeView extends View
{
    public function __construct(HomeModel $model)
    {
        parent::__construct($model);
        
        $login = new Login();
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
    }
    
    public function index()
    {
        $this->template = new HtmlTemplate('Home');
        $this->template->title = 'App/Home';
    }
}
