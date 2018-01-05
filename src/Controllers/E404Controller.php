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

use App\Models\NullModel;
use Linna\Mvc\Controller;

/**
 * Error 404 Controller.
 */
class E404Controller extends Controller
{
    /**
     * Constructor.
     *
     * @param NullModel $model
     */
    public function __construct(NullModel $model)
    {
        //call parent construct
        parent::__construct($model);
    }
}
