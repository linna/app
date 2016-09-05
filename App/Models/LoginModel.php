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

namespace App\Models;

use Linna\Mvc\Model;
use Linna\Auth\Login;
use Linna\Auth\Password;
use Linna\Session\Session;

use App\DomainObjects\User;
use App\Mappers\UserMapper;

class LoginModel extends Model
{
    protected $login;

    public function __construct()
    {
        parent::__construct();
        
        $this->login = new Login(Session::getInstance());
    }

    public function doLogin($user, $password)
    {
        $userMapper = new UserMapper();

        $dbUser = $userMapper->findByName($user);
        
        if (!($dbUser instanceof User)) {
            
            $this->getUpdate = ['loginError' => true];
            
            return false;
        }

        if ($this->login->login($user, $password, $dbUser->name, $dbUser->password, $dbUser->getId())) {
            
            $this->updatePassword($password, $dbUser, $userMapper);
            
            return true;
        }
        
        $this->getUpdate = ['loginError' => true];

        return false;
    }

    public function logout()
    {
        $this->login->logout();
    }

    protected function updatePassword($password, User $user, UserMapper $mapper)
    {
        $passUtil = new Password();

        if ($passUtil->needsRehash($user->password)) {
            $user->setPassword($password);
            $mapper->save($user);
        }
    }

}
