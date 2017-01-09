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
        if ($this->authentication === false){return;}
        
        $this->model->enable($userId);
    }

    public function disable(int $userId)
    {
        if ($this->authentication === false){return;}
        
        $this->model->disable($userId);
    }

    public function delete(int $userId)
    {
        if ($this->authentication === false){return;}
        
        $this->model->delete($userId);
    }

    public function changePassword(int $userId)
    {
        if ($this->authentication === false){return;}
        
        $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING);
        
        $this->model->changePassword($userId, $newPassword, $confirmPassword);
    }

    public function modify(int $userId)
    {
        if ($this->authentication === false){return;}
        
        $newUserName = filter_input(INPUT_POST, 'newUserName', FILTER_SANITIZE_STRING);
        $newUserDescription = filter_input(INPUT_POST, 'newUserDescription', FILTER_SANITIZE_STRING);
        
        $this->model->modify($userId, $newUserName, $newUserDescription);
    }
}
