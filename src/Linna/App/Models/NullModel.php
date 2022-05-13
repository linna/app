<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Models;

use Linna\Mvc\Model;

/**
 * Null Model.
 * Use this class when a page not need data from persistent storage.
 */
class NullModel extends Model
{
    /**
     * Class Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }
}
