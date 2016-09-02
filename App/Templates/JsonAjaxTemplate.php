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

namespace App\Templates;

use Linna\Mvc\TemplateInterface;

class JsonAjaxTemplate implements TemplateInterface
{
    public $data = null;
    
    
    public function __construct()
    {
        $this->data = (object) null;
    }
    
    public function output()
    {
        echo json_encode($this->data);
    }
}
