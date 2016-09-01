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
use App\DomainObjects\User;
use App\Mappers\UserMapper;

class LoginModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function doLogin($user, $password)
    {
        $login = new Login();
        $userMapper = new UserMapper();

        $dbUser = $userMapper->findByName($user);

        if ($dbUser instanceof User) {
            
           if ($login->login($user,
                    $password,
                    $dbUser->name,
                    $dbUser->password,
                    $dbUser->getId())) {
            
            $this->updatePassword($password, $dbUser, $userMapper);
                
            return true;
        
            }
        }
        
        $this->getUpdate = ['loginError' => true];
        $this->notify();
        
        return false;
    }
    
    public function logout()
    {
        $login = new Login();
        $login->logout();
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
