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

class HtmlAjaxTemplate implements TemplateInterface
{
    protected $template = null;
    
    public $data = null;
    
    
    public function __construct()
    {
        $this->data = (object) null;
    }
    
    /**
     * Load html file
     * 
     * @param string $file Html file
     */
    public function loadHtml($file)
    {
        $this->template = $file;
    }
   
    public function output()
    {
        $template = $this->template;
        
        $data = $this->data;
       
        ob_start();
        
        try {
            if (!file_exists(APP."Templates/_pages/{$template}.html")) {
                throw new \Exception("The required Template ({$template}) not exist.");
            }

           
            require APP."Templates/_pages/{$template}.html";
        } catch (\Exception $e) {
            echo 'Template exception: ', $e->getMessage(), "\n";
        }
        
        ob_end_flush();
    }
}
