<?php

namespace App\Views;

use Leviu\Mvc\View;
use Leviu\Auth\Login;

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
