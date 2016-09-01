<?php

namespace App\Controllers;

use Linna\Mvc\Controller;
use App\Models\HomeModel;

class HomeController extends Controller
{
    public function __construct(HomeModel $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
           
    }
}
