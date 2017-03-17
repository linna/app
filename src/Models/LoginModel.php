<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Models;

use App\Mappers\UserMapper;
use Linna\Auth\Authenticate;
use Linna\Auth\Password;
use Linna\Auth\User;
use Linna\Mvc\Model;

/**
 * Login Model.
 */
class LoginModel extends Model
{
    /**
     * @var object Login class
     */
    protected $login;

    /**
     * @var object User Mapper class
     */
    protected $userMapper;

    /**
     * @var object Password Class
     */
    protected $password;

    /**
     * Constructor.
     *
     * @param UserMapper $userMapper
     * @param Login      $login
     * @param Password   $password
     */
    public function __construct(UserMapper $userMapper, Authenticate $login, Password $password)
    {
        parent::__construct();

        $this->login = $login;
        $this->userMapper = $userMapper;
        $this->password = $password;
    }

    /**
     * Do Login.
     *
     * @param string $userName
     * @param string $userPassword
     *
     * @return bool
     */
    public function doLogin(string $userName, string $userPassword) : bool
    {
        //get user from databese
        $dbUser = $this->userMapper->fetchByName($userName);

        //if user is not a Userobject return error
        if (!($dbUser instanceof User)) {

            //update data for view
            $this->getUpdate = ['loginError' => true];

            return false;
        }

        //check login
        if ($this->login->login($userName, $userPassword, $dbUser->name, $dbUser->password, $dbUser->getId())) {

            //check if password need rehash
            $this->updatePassword($userPassword, $dbUser);

            return true;
        }

         //update data for view
        $this->getUpdate = ['loginError' => true];

        return false;
    }

    /**
     * Logout.
     */
    public function logout()
    {
        $this->login->logout();
    }

    /**
     * Update Password.
     *
     * @param string $password
     * @param User   $user
     */
    protected function updatePassword(string $password, User $user)
    {
        //if password needs rehash for user
        if ($this->password->needsRehash($user->password)) {

            //set new password for user
            $user->setPassword($password);
            //save user
            $this->userMapper->save($user);
        }
    }
}
