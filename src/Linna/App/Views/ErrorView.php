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

use Linna\App\Templates\HtmlTemplate;
use Linna\Mvc\View;

/**
 * Error View.
 */
class ErrorView extends View
{
    /**
     * Constructor.
     *
     * @param HtmlTemplate $htmlTemplate
     */
    public function __construct(HtmlTemplate $htmlTemplate)
    {
        parent::__construct($htmlTemplate);
    }

    /**
     * Entry Point for the error view.
     */
    public function entryPoint(): void
    {
        //load error 404 html
        $this->template->loadHtml('Error');

        //set page title
        $this->template->title = 'App/Page not found';
    }
}
