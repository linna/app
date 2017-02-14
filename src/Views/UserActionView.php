<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Views;

use App\Models\UserModel;
use App\Templates\JsonTemplate;
use Linna\Auth\Login;
use Linna\Mvc\View;

/**
 * User View.
 */
class UserActionView extends View
{
    /**
     * Constructor.
     *
     * @param UserModel    $model
     * @param Login        $login
     * @param JsonTemplate $jsonTemplate
     */
    public function __construct(UserModel $model, Login $login, JsonTemplate $jsonTemplate)
    {
        parent::__construct($model);

        //merge data passed from model with login information
        $this->data = array_merge($this->data, ['login' => $login->logged, 'userName' => $login->data['user_name']]);

        //store templates
        $this->template = $jsonTemplate;
    }

    /**
     * Enable User.
     */
    public function enable()
    {
        //do nothing
    }

    /**
     * Disable User.
     */
    public function disable()
    {
        //do nothing
    }

    /**
     * Delete User.
     */
    public function delete()
    {
        //do nothing
    }

    /**
     * Change Password.
     */
    public function changePassword()
    {
        //do nothing
    }

    /**
     * Modify Userr.
     */
    public function modify()
    {
        //do nothing
    }
}
