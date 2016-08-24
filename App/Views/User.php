<?php

namespace App\Views;

use Leviu\Mvc\AbstractView;
use App\Models\User as UserModel;

class User extends AbstractView
{
    
    public function __construct()
    {
        $this->data = (object) array('isLogged'=> false, 'userName' => null);
    }
    
    public function showAllUser()
    {
        $userModel = new UserModel();
        
        $this->data->users = $userModel->getAllUsers();
    }
}
