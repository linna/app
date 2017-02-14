<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Controllers;

use App\Models\LoginModel;
use Linna\Mvc\Controller;

/**
 * Login Controller.
 */
class LoginController extends Controller
{
    /**
     * Contructor.
     *
     * @param LoginModel $model
     */
    public function __construct(LoginModel $model)
    {
        parent::__construct($model);
    }

    /**
     * Execute Login.
     *
     * @return void
     */
    public function doLogin()
    {
        //sanitize input
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

        //call login procedure from model and check if ok
        if ($this->model->doLogin($user, $password) === true) {
            //return to home
            header('location: '.URL);

            return;
        }
    }

    /**
     * Logout.
     */
    public function logout()
    {
        //do logout
        $this->model->logout();
        //return to home
        header('location: '.URL);
    }
}
