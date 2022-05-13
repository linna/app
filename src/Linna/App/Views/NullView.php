<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Views;

use Linna\App\Models\NullModel;
use Linna\App\Templates\NullTemplate;
use Linna\Mvc\View;

/**
 * Null View.
 */
class NullView extends View
{
    /**
     * Class Constructor.
     */
    public function __construct(NullModel $model, NullTemplate $template)
    {
        parent::__construct($model, $template);
    }
}
