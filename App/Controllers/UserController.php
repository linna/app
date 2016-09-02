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

    public function __construct(UserModel $model)
    {
        parent::__construct($model);
        
        $this->protect(new Login, URL.'login');
    }

    public function index()
    {
    }

    public function enable($userId)
    {
        $this->model->enable($userId);
    }

    public function disable($userId)
    {
        $this->model->disable($userId);
    }

    public function delete($userId)
    {
        $this->model->delete($userId);
    }

    public function changePassword($userId)
    {
        //apply data filter to $_POST
        $this->model->changePassword($userId, $_POST['new_password'], $_POST['confirm_password']);
    }

    public function modify($userId)
    {
        //apply data filter to $_POST
        $this->model->modify($userId, $_POST['new_user_name'], $_POST['new_user_description']);
    }
}
