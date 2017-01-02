<?php

/**
 * Linna App
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 *
 */

namespace App\Controllers;

use Linna\Mvc\Controller;

use App\Models\LoginModel;

class LoginController extends Controller
{
    public function __construct(LoginModel $model)
    {
        parent::__construct($model);
    }
    
    public function doLogin()
    {
        $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        
        $login = $this->model->doLogin($user, $password);

        if ($login === true) {
            header('location: '.URL);
            return;
        }
    }

    public function logout()
    {
        $this->model->logout();

        header('location: '.URL);
    }
}
