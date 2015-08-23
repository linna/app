<?php

namespace App\Models;

use Leviu\Routing\Model;
use Leviu\Auth\UserMapper;

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
        $userMapper =  new UserMapper();
                
        $user = $userMapper->findById($id);
        $user->active = 1;
        
        $userMapper->save($user);
    }
    
    public function disable($id)
    {
        $userMapper =  new UserMapper();
                
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
}
