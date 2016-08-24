<?php

namespace App\Views;

use Leviu\Mvc\View;
use App\Models\HomeModel;
use App\Templates\HtmlTemplate;

class HomeView extends View
{
    public function __construct(HomeModel $model)
    {
        parent::__construct($model);
    }
    
    public function index()
    {
        $this->template = new HtmlTemplate('Home');
        $this->template->title = 'App/Home';
        
        $this->data = (object) array('isLogged'=> false, 'userName' => null);
    }
}
