<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Views;

use App\Models\E404Model;
use App\Templates\HtmlTemplate;
use Linna\Auth\Authenticate;
use Linna\Mvc\View;

/**
 * Error 404 View.
 */
class E404View extends View
{
    /**
     * Constructor.
     *
     * @param E404Model    $model
     * @param Authenticate $login
     * @param HtmlTemplate $htmlTemplate
     */
    public function __construct(E404Model $model, Authenticate $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);

        //merge data passed from model with login information
        $this->data = array_merge($this->data, ['login' => $login->logged, 'userName' => $login->data['user_name']]);

        //store html template
        $this->template = $htmlTemplate;
    }

    /**
     * Index.
     */
    public function index()
    {
        //load error 404 html
        $this->template->loadHtml('Error404');

        //set page title
        $this->template->title = 'App/Page not found';
    }
}
