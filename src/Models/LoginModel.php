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

namespace App\Models;

use Linna\Mvc\Model;
use Linna\Auth\Login;
use Linna\Auth\Password;

use App\DomainObjects\User;
use App\Mappers\UserMapper;

class LoginModel extends Model
{
    protected $login;
    
    protected $userMapper;
    
    protected $password;
    
    public function __construct(UserMapper $userMapper, Login $login, Password $password)
    {
        parent::__construct();
        
        $this->login = $login;
        $this->userMapper = $userMapper;
        $this->password = $password;
    }

    public function doLogin(string $userName, string $userPassword) : bool
    {
        $dbUser = $this->userMapper->findByName($userName);
        
        if (!($dbUser instanceof User)) {
            $this->getUpdate = ['loginError' => true];
            
            return false;
        }

        if ($this->login->login($userName, $userPassword, $dbUser->name, $dbUser->password, $dbUser->getId())) {
            $this->updatePassword($userPassword, $dbUser);
            
            return true;
        }
        
        $this->getUpdate = ['loginError' => true];

        return false;
    }

    public function logout()
    {
        $this->login->logout();
    }

    protected function updatePassword(string $password, User $user)
    {
        if ($this->password->needsRehash($user->password)) {
            $user->setPassword($password);
            $this->userMapper->save($user);
        }
    }
}
