<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace App\Controllers;

use App\Models\HomeModel;
use Linna\Mvc\Controller;

/**
 * Home Page Controller.
 */
class HomeController extends Controller
{
    /**
     * Constructor.
     *
     * @param HomeModel $model
     */
    public function __construct(HomeModel $model)
    {
        parent::__construct($model);
    }
}
