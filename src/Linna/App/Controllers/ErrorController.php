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

use Linna\App\Models\ErrorModel;
use Linna\App\Views\ErrorView;
use Linna\Mvc\Controller;
use Linna\Router\Route;

/**
 * Error Controller.
 */
#[Route(
    name:       'Error',
    method:     'GET',
    path:       '/error/[code]',
    model:      ErrorModel::class,
    view:       ErrorView::class,
)]
class ErrorController extends Controller
{
    /** @var array Status codes */
    private $status = [
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed'
    ];

    /**
     * Constructor.
     *
     * @param ErrorModel $model
     */
    public function __construct(ErrorModel $model)
    {
        //call parent construct
        parent::__construct($model);
    }

    /**
     * Error entrypoint.
     *
     * @param string $code
     *
     * @return void
     */
    public function entryPoint(string $code): void
    {
        \settype($code, 'int');

        //default
        $statusCode = 404;
        $description = $this->status[404];

        if (isset($this->status[$code])) {
            $statusCode = $code;
            $description = $this->status[$code];
        }

        \http_response_code($statusCode);

        $this->model->raiseError($statusCode, $description);
    }
}
