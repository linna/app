<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Controllers;

use App\Models\E404Model;
use Linna\Mvc\Controller;

/**
 * Error 404 Controller.
 */
class E404Controller extends Controller
{
    /**
     * Constructor.
     *
     * @param E404Model $model
     */
    public function __construct(E404Model $model)
    {
        //call parent construct
        parent::__construct($model);
    }
}
