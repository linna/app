<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace App\Views;

use App\Models\ErrorModel;
use App\Templates\HtmlTemplate;
use Linna\Mvc\View;

/**
 * Error View.
 */
class ErrorView extends View
{
    /**
     * Constructor.
     *
     * @param ErrorModel    $model
     * @param HtmlTemplate  $htmlTemplate
     */
    public function __construct(ErrorModel $model, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model, $htmlTemplate);
    }

    /**
     * Index.
     */
    public function index(): void
    {
        //load error 404 html
        $this->template->loadHtml('Error');

        //set page title
        $this->template->title = 'App/Page not found';
    }
}
