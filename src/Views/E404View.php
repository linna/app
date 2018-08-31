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

use App\Models\NullModel;
use App\Templates\HtmlTemplate;
use Linna\Authentication\Authentication;
use Linna\Mvc\View;

/**
 * Error 404 View.
 */
class E404View extends View
{
    /**
     * Constructor.
     *
     * @param NullModel      $model
     * @param Authentication $login
     * @param HtmlTemplate   $htmlTemplate
     */
    public function __construct(NullModel $model, Authentication $login, HtmlTemplate $htmlTemplate)
    {
        parent::__construct($model);

        //merge data passed from model with login information
        $this->data = array_merge($this->data, ['login' => $login->islogged(), 'userName' => $login->getLoginData()['user_name']]);

        //store html template
        $this->template = $htmlTemplate;
    }

    /**
     * Index.
     */
    public function index()
    {
        //set 404 error
        header("HTTP/1.1 404 Not Found");

        //load error 404 html
        $this->template->loadHtml('Error404');

        //set page title
        $this->template->title = 'App/Page not found';
    }
}
