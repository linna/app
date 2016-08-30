<?php

namespace App\Views;

use Leviu\Mvc\View;
use Leviu\Auth\Login;

use App\Models\E404Model;
use App\Templates\HtmlTemplate;

class E404View extends View
{
    public function __construct(E404Model $model)
    {
        parent::__construct($model);
        
        $login = new Login();
        
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
    }
    
    public function index()
    {
        $this->template = new HtmlTemplate('Error404');
        $this->template->title = 'App/Page not found';
    }
}
