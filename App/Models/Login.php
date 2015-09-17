<?php

namespace App\Models;

use Leviu\Routing\Model;
use Leviu\Auth\Login as LoginClass;
use App\Mappers\UserMapper;

class Login extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function doLogin()
    {
        $login = new LoginClass();
        $userMapper = new UserMapper();
        
        
        $tmp = $userMapper->findByName($_POST['user']);
        
        $user = $_POST['user'];
        $password = $_POST['password'];
        
        $storedUser = ($tmp) ? $tmp->name : '';
        $storedPassword =  ($tmp) ? $tmp->password : '';
        $storedId = ($tmp) ? $tmp->getId() : 0;
        
        
        return $login->login($user, $password, $storedUser, $storedPassword, $storedId);
    }

    public function logout()
    {
        $login = new LoginClass();
        
        $login->logout();
    }
}
