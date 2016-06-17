<?php

namespace App\Models;

use Leviu\Routing\Model;
use Leviu\Auth\Password;
use App\Mappers\UserMapper;

class User extends Model
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
    }

    public function disable($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);

        if ($user->name !== 'root') {
            $user->active = 0;
        }

        $userMapper->save($user);
    }

    public function delete($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);

        if ($user->name !== 'root') {
            //$userMapper->delete($user);
        }
    }

    public function changePassword($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);

        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        $password = new Password();

        //password must be not nulla
        if ($newPassword === null || $newPassword === '') {
            return 2;
        }

        //password must be equal to confirm password
        if ($newPassword !== $confirmPassword) {
            return 1;
        }

        $hash = $password->hash($newPassword);

        $user->password = $hash;

        $userMapper->save($user);

        return 0;
    }

    public function modify($id)
    {
        $userMapper = new UserMapper();

        $user = $userMapper->findById($id);

        $newName = $_POST['new_user_name'];
        $newDescription = $_POST['new_user_description'];

        $checkUser = $userMapper->findByName($newName);

        //user name must be not null
        if ($newName === null || $newName === '') {
            return 2;
        }

        //user name must be unique
        if (isset($checkUser->name) && $checkUser->name !== $user->name) {
            return 1;
        }

        $user->name = $newName;
        $user->description = $newDescription;

        $userMapper->save($user);

        return 0;
    }
}
