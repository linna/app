<?php

namespace App\Controllers;

use Leviu\Mvc\Controller;
use Leviu\Auth\Login;
use Leviu\Auth\ProtectedController;

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

    public function enable($user_id)
    {
        $this->model->enable($user_id);
    }

    public function disable($user_id)
    {
        $this->model->disable($user_id);
    }

    public function delete($user_id)
    {
        $this->model->delete($user_id);
    }

    public function changePassword($user_id)
    {
        $this->model->changePassword($user_id);
    }

    public function modify($user_id)
    {
        $this->model->modify($user_id);
    }
}
