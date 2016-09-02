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
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllUsers()
    {
        $userMapper = new UserMapper();

        return $userMapper->getAllUsers();
    }

    public function enable($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);
        $user->active = 1;

        $userMapper->save($user);

        $this->getUpdate = ['error' => 0];
        
        return;
    }

    public function disable($userId)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($userId);

        if ($user->name !== 'root') {
            $user->active = 0;
        }

        $userMapper->save($user);

        $this->getUpdate = ['error' => 0];
        
        return;
    }

    public function delete($userId)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($userId);

        if ($user->name !== 'root') {
            $userMapper->delete($user);
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
        $userMapper = new UserMapper();
        $user = $userMapper->findById($userId);

        $hash = $password->hash($newPassword);

        $user->password = $hash;

        $userMapper->save($user);

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

        $userMapper = new UserMapper();

        $checkUser = $userMapper->findByName($newName);
        $user = $userMapper->findById($userId);
        
        //user name must be unique
        if (isset($checkUser->name) && $checkUser->name !== $user->name) {
            $this->getUpdate = ['error' => 1];
            return;
        }

        $user->name = $newName;
        $user->description = $newDescription;

        $userMapper->save($user);

        $this->getUpdate = ['error' => 0];

        return;
    }
}
