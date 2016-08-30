<?php

namespace App\Models;

use Leviu\Mvc\Model;
use Leviu\Auth\Password;
use App\Mappers\UserMapper;

class UserModel extends Model
{

    public function __contruct()
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
        $this->notify();
        return;
    }

    public function disable($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);

        if ($user->name !== 'root') {
            $user->active = 0;
        }

        $userMapper->save($user);

        $this->getUpdate = ['error' => 0];
        $this->notify();
        return;
    }

    public function delete($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);

        if ($user->name !== 'root') {
            $userMapper->delete($user);
        }

        return 0;
    }

    public function changePassword($id)
    {
        //da filtrare nel controller
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        //password must be not null
        if ($newPassword === null || $newPassword === '') {
            $this->getUpdate = ['error' => 2];
            $this->notify();
            return;
        }

        //password must be equal to confirm password
        if ($newPassword !== $confirmPassword) {
            $this->getUpdate = ['error' => 1];
            $this->notify();
            return;
        }

        $password = new Password();
        $userMapper = new UserMapper();
        $user = $userMapper->findById($id);

        $hash = $password->hash($newPassword);

        $user->password = $hash;

        $userMapper->save($user);

        $this->getUpdate = ['error' => 0];
        $this->notify();

        return;
    }

    public function modify($id)
    {
        //da filtrare nel controller
        $newName = $_POST['new_user_name'];
        $newDescription = $_POST['new_user_description'];

        //user name must be not null
        if ($newName === null || $newName === '') {
            $this->getUpdate = ['error' => 2];
            $this->notify();
            return;
        }

        $userMapper = new UserMapper();

        $checkUser = $userMapper->findByName($newName);
        $user = $userMapper->findById($id);

        //user name must be unique
        if (isset($checkUser->name) && $checkUser->name !== $user->name) {
            $this->getUpdate = ['error' => 1];
            $this->notify();
            return;
        }


        $user->name = $newName;
        $user->description = $newDescription;

        $userMapper->save($user);

        $this->getUpdate = ['error' => 0];
        $this->notify();
        return;
    }
}
