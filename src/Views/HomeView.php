<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace App\Views;

use App\Models\HomeModel;
use App\Templates\HtmlTemplate;
use Linna\Auth\Authenticate;
use Linna\Mvc\View;

/**
 * Home Page View.
 */
class HomeView extends View
{
    /**
     * Constructor.
     *
     * @param HomeModel    $model
     * @param Authenticate $login
     * @param HtmlTemplate $htmlTemplate
     */
    public function __construct(HomeModel $model, Authenticate $login, HtmlTemplate $htmlTemplate)
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
        //load home html
        $this->template->loadHtml('Home');

        //set page title
        $this->template->title = 'App/Home';
    }
}
