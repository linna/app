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

use App\Models\E404Model;
use App\Templates\HtmlTemplate;

class E404View extends View
{
    private $htmlTemplate;
    
    public function __construct(E404Model $model, Login $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        $this->htmlTemplate = $htmlTemplate;
    }
    
    public function index()
    {
        $this->template = $this->htmlTemplate;
        
        $this->template->loadHtml('Error404');
        
        $this->template->title = 'App/Page not found';
    }
}
