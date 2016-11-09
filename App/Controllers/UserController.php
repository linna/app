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

namespace App\Controllers;

use Linna\Mvc\Controller;
use Linna\Auth\Login;
use Linna\Auth\ProtectedController;

use App\Models\UserModel;

class UserController extends Controller
{
    use ProtectedController;

    public function __construct(UserModel $model, Login $login)
    {
        parent::__construct($model);
        
        $this->protect($login, URL.'login');
    }

    public function enable(int $userId)
    {
        $this->model->enable($userId);
    }

    public function disable(int $userId)
    {
        $this->model->disable($userId);
    }

    public function delete(int $userId)
    {
        $this->model->delete($userId);
    }

    public function changePassword(int $userId)
    {
        $newPassword = filter_input(INPUT_POST, 'new_password', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING);
        
        $this->model->changePassword($userId, $newPassword, $confirmPassword);
    }

    public function modify(int $userId)
    {
        $newUserName = filter_input(INPUT_POST, 'new_user_name', FILTER_SANITIZE_STRING);
        $newUserDescription = filter_input(INPUT_POST, 'new_user_description', FILTER_SANITIZE_STRING);
        
        $this->model->modify($userId, $newUserName, $newUserDescription);
    }
}
