<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Controllers;

use App\Models\UserModel;
use Linna\Auth\Authenticate;
use Linna\Auth\ProtectedController;
use Linna\Mvc\Controller;

/**
 * User Controller.
 */
class UserController extends Controller
{
    //trait for protect this controller
    use ProtectedController;

    /**
     * Contructor.
     *
     * @param UserModel $model
     * @param Authenticate     $login
     */
    public function __construct(UserModel $model, Authenticate $login)
    {
        parent::__construct($model);

        //call trait function for protect controller
        $this->protect($login, URL.'login');
    }

    /**
     * Enable User.
     *
     * @param int $userId
     *
     * @return void
     */
    public function enable(int $userId)
    {
        //check authentication
        if ($this->authentication === false) {
            return;
        }

        //call model for enable
        $this->model->enable($userId);
    }

    /**
     * Disable User.
     *
     * @param int $userId
     *
     * @return void
     */
    public function disable(int $userId)
    {
        //check authentication
        if ($this->authentication === false) {
            return;
        }

        //call model for do disable action
        $this->model->disable($userId);
    }

    /**
     * Delete User.
     *
     * @param int $userId
     *
     * @return void
     */
    public function delete(int $userId)
    {
        //check authentication
        if ($this->authentication === false) {
            return;
        }

        //call model for do delete action
        $this->model->delete($userId);
    }

    /**
     * Change User Password.
     *
     * @param int $userId
     *
     * @return void
     */
    public function changePassword(int $userId)
    {
        //check authentication
        if ($this->authentication === false) {
            return;
        }

        $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_STRING);
        $confirmPassword = filter_input(INPUT_POST, 'confirmPassword', FILTER_SANITIZE_STRING);

        //call model for do change password action
        $this->model->changePassword($userId, $newPassword, $confirmPassword);
    }

    /**
     * Modify User.
     *
     * @param int $userId
     *
     * @return void
     */
    public function modify(int $userId)
    {
        //check authentication
        if ($this->authentication === false) {
            return;
        }

        $newUserName = filter_input(INPUT_POST, 'newUserName', FILTER_SANITIZE_STRING);
        $newUserDescription = filter_input(INPUT_POST, 'newUserDescription', FILTER_SANITIZE_STRING);

        //call model for do modify action
        $this->model->modify($userId, $newUserName, $newUserDescription);
    }
}
