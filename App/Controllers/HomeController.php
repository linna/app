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
