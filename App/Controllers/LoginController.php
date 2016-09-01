<?php

/**
 * Linna App
 *
 * 
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2016, Sebastian Rapetti
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
    
    public function index()
    {
        
    }
    
    public function doLogin()
    {
        //apply data filter to $_POST
        $login = $this->model->doLogin($_POST['user'], $_POST['password']);

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
