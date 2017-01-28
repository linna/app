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

namespace App\Views;

use Linna\Mvc\View;
use Linna\Auth\Login;
use App\Models\UserModel;
use App\Templates\HtmlTemplate;
use App\Templates\JsonTemplate;

/**
 * User View
 *
 */
class UserView extends View
{
    /**
     * @var HtmlTemplate $htmlTemplate Template for hatml pages
     */
    private $htmlTemplate;
    
    /**
     * @var JsonTemplate $jsonTemplate Template for json data format
     */
    private $jsonTemplate;
    
    /**
     * Constructor
     *
     * @param UserModel $model
     * @param Login $login
     * @param HtmlTemplate $htmlTemplate
     * @param JsonTemplate $jsonTemplate
     */
    public function __construct(UserModel $model, Login $login, HtmlTemplate $htmlTemplate, JsonTemplate $jsonTemplate)
    {
        parent::__construct($model);
        
        //merge data passed from model with login information
        $this->data = array_merge($this->data, array('login' => $login->logged, 'userName' => $login->data['user_name']));
        
        //store templates
        $this->htmlTemplate = $htmlTemplate;
        $this->jsonTemplate = $jsonTemplate;
    }
    
    /**
     * Index
     *
     */
    public function index()
    {
        //template configuration
        $this->template = $this->htmlTemplate;
        
        //load user template
        $this->template->loadHtml('User');
        //load user css
        $this->template->loadCss('css/user.css');

        //load javascript tools
        $this->template->loadJs('js/ajax.js');
        $this->template->loadJs('js/dialog.js');

        //load specific js script for this controller
        $this->template->loadJs('js/user.js');
        
        //set page title
        $this->template->title = 'App/User';
        
        //store data for view
        $this->data['users'] = $this->model->getAllUsers();
    }
    
    /**
     * Enable User
     *
     */
    public function enable()
    {
        //set template
        $this->template = $this->jsonTemplate;
    }

    /**
     * Disable User
     *
     */
    public function disable()
    {
        //set template
        $this->template = $this->jsonTemplate;
    }

    /**
     * Delete User
     *
     */
    public function delete()
    {
        //set template
        $this->template = $this->jsonTemplate;
    }

    /**
     * Change Password
     */
    public function changePassword()
    {
        //set template
        $this->template = $this->jsonTemplate;
    }
    
    /**
     * Modify Userr
     *
     */
    public function modify()
    {
        //set template
        $this->template = $this->jsonTemplate;
    }
}
