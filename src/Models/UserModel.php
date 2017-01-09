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
use Linna\Auth\Password;
use App\Mappers\UserMapper;
use App\DomainObjects\User;

class UserModel extends Model
{
    protected $mapper;
    
    protected $password;
    
    public function __construct(UserMapper $userMapper, Password $password)
    {
        parent::__construct();
        
        $this->mapper = $userMapper;
        
        $this->password = $password;
    }

    public function getAllUsers()
    {
        return $this->mapper->getAllUsers();
    }

    public function enable(int $userId)
    {
        $user = $this->mapper->findById($userId);
        $user->active = 1;

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];
        
        return;
    }

    public function disable(int $userId)
    {
        $user = $this->mapper->findById($userId);

        if ($user->name !== 'root') {
            $user->active = 0;
        }

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];
        
        return;
    }

    public function delete(int $userId)
    {
        $user = $this->mapper->findById($userId);

        if ($user->name !== 'root') {
            $this->mapper->delete($user);
        }

        return 0;
    }
    
    protected function changePasswordChecks(string $newPassword, string $confirmPassword) :bool
    {
        //password must be not null
        if ($newPassword === null || $newPassword === '') {
            $this->getUpdate = ['error' => 2];
            return false;
        }

        //password must be equal to confirm password
        if ($newPassword !== $confirmPassword) {
            $this->getUpdate = ['error' => 1];
            return false;
        }
        
        return true;
    }
    
    public function changePassword(int $userId, string $newPassword, string $confirmPassword)
    {
        //do password checks
        if ($this->changePasswordChecks($newPassword, $confirmPassword) === false){return;}
        
        $user = $this->mapper->findById($userId);
        $user->password = $this->password->hash($newPassword);

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];

        return;
    }
    
    protected function modifyCheks(User $user, string $newName, string $newDescription) : bool
    {
        //user name must be not null
        if ($newName === null || $newName === '') {
            $this->getUpdate = ['error' => 2];
            return false;
        }
        
        //search for user with new username
        $checkUser = $this->mapper->findByName($newName);
                
        //user name must be unique
        if (isset($checkUser->name) && $checkUser->name !== $user->name) {
            $this->getUpdate = ['error' => 1];
            return false;
        }
        
        return true;
    }
    
    public function modify(int $userId, string $newName, string $newDescription)
    {
        $user = $this->mapper->findById($userId);
        
        if ($this->modifyCheks($user, $newName, $newDescription) === false){return;}
        
        $user->name = $newName;
        $user->description = $newDescription;

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];

        return;
    }
}
