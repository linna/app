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
use Linna\Session\Session;

use App\Models\HomeModel;
use App\Templates\HtmlTemplate;

class HomeView extends View
{
    private $htmlTemplate;
    
    public function __construct(HomeModel $model, Login $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        $this->htmlTemplate = $htmlTemplate;
    }
    
    public function index()
    {
        $this->template = $this->htmlTemplate;
        
        $this->template->loadHtml('Home');
        
        $this->template->title = 'App/Home';
    }
}
