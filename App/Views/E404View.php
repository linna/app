<?php

namespace App\Views;

use Leviu\Mvc\View;
use App\Models\E404Model;
use App\Templates\HtmlTemplate;

class E404View extends View
{
    public function __construct(E404Model $model)
    {
        parent::__construct($model);
    }
    
    public function index()
    {
        $this->template = new HtmlTemplate('Error404');
        $this->template->title = 'App/Page not found';
        
        $this->data = (object) array('isLogged'=> false, 'userName' => null);
    }
}
