<?php

namespace App\Models;

use Leviu\Routing\Model;
use Leviu\Auth\Login as LoginClass;

class Login extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function doLogin()
    {
        $login = new LoginClass();
        
        return $login->login($_POST['user'], $_POST['password']);
    }

    public function logout()
    {
        $login = new LoginClass();
        
        $login->logout();
    }
}
