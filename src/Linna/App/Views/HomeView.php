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

use Linna\App\Models\HomeModel;
use Linna\App\Templates\HtmlTemplate;
use Linna\Authentication\Authentication;
use Linna\Mvc\View;

/**
 * Home Page View.
 */
class HomeView extends View
{
    /**
     * Constructor.
     *
     * @param HomeModel      $model
     * @param HtmlTemplate   $htmlTemplate
     * @param Authentication $login
     */
    public function __construct(HomeModel $model, HtmlTemplate $htmlTemplate, Authentication $login)
    {
        parent::__construct($model, $htmlTemplate);

        //merge data passed from model with login information
        $this->data = \array_merge($this->data, ['login' => $login->islogged(), 'userName' => $login->getLoginData()['user_name']]);
    }

    /**
     * Entry Point for the home view.
     */
    public function entryPoint(): void
    {
        //load home html
        $this->template->loadHtml('Home');

        //set page title
        $this->template->title = 'App/Home';
    }
}
