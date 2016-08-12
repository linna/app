<?php

namespace App\Models;

use Leviu\Mvc\Model;
use Leviu\Auth\Login as LoginClass;
use Leviu\Auth\Password;
use Leviu\Database\DomainObjectAbstract;
use Leviu\Database\MapperAbstract;
use App\Mappers\UserMapper;

class Login extends Model
{
    public function __construct()
    {
    }

    public function doLogin()
    {
        $login = new LoginClass();
        $userMapper = new UserMapper();

        $dbUser = $userMapper->findByName($_POST['user']);

        if ($dbUser instanceof DomainObjectAbstract) {
            if ($login->login($_POST['user'],
                    $_POST['password'],
                    $dbUser->name,
                    $dbUser->password,
                    $dbUser->getId())) {
                $this->updatePassword($_POST['password'], $dbUser, $userMapper);
                
                return true;
            }
        }
        
        return false;
    }
    
    public function logout()
    {
        $login = new LoginClass();

        $login->logout();
    }
    
    protected function updatePassword($password, DomainObjectAbstract $user, MapperAbstract $mapper)
    {
        $p = new Password();
        
        if ($p->needs_rehash($user->password)) {
            $user->setPassword($password);
            $mapper->save($user);
        }
    }
}
