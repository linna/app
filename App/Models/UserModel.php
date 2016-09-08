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
use Linna\Auth\Password;
use App\Mappers\UserMapper;

class UserModel extends Model
{
    protected $mapper;
    
    public function __construct(UserMapper $userMapper)
    {
        parent::__construct();
        
        $this->mapper = $userMapper;
    }

    public function getAllUsers()
    {
        return $this->mapper->getAllUsers();
    }

    public function enable($id)
    {
        $user = $this->mapper->findById($id);
        $user->active = 1;

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];
        
        return;
    }

    public function disable($userId)
    {
        $user = $this->mapper->findById($userId);

        if ($user->name !== 'root') {
            $user->active = 0;
        }

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];
        
        return;
    }

    public function delete($userId)
    {
        $user = $this->mapper->findById($userId);

        if ($user->name !== 'root') {
            $this->mapper->delete($user);
        }

        return 0;
    }

    public function changePassword($userId, $newPassword, $confirmPassword)
    {
        //password must be not null
        if ($newPassword === null || $newPassword === '') {
            $this->getUpdate = ['error' => 2];
            return;
        }

        //password must be equal to confirm password
        if ($newPassword !== $confirmPassword) {
            $this->getUpdate = ['error' => 1];
            return;
        }

        $password = new Password();
        
        $user = $this->mapper->findById($userId);
        $user->password = $password->hash($newPassword);

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];

        return;
    }

    public function modify($userId, $newName, $newDescription)
    {
        //user name must be not null
        if ($newName === null || $newName === '') {
            $this->getUpdate = ['error' => 2];
            return;
        }

        $checkUser = $this->mapper->findByName($newName);
        $user = $this->mapper->findById($userId);
        
        //user name must be unique
        if (isset($checkUser->name) && $checkUser->name !== $user->name) {
            $this->getUpdate = ['error' => 1];
            return;
        }

        $user->name = $newName;
        $user->description = $newDescription;

        $this->mapper->save($user);

        $this->getUpdate = ['error' => 0];

        return;
    }
}
