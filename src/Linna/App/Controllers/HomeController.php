<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Controllers;

use Linna\App\Models\HomeModel;
use Linna\Mvc\Controller;

/**
 * Home Page Controller.
 */
#[
    Route(
        name:       'Home',
        method:     'GET',
        path:       '/',
        model:      Linna\App\Models\HomeModel::class,
        view:       Linna\App\Views\HomeView::class
    )
]
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
