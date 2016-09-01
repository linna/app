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
use App\Models\E404Model;

class E404Controller extends Controller
{
    public function __construct(E404Model $model)
    {
        parent::__construct($model);
    }

    public function index()
    {
    }
}
