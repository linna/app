<?php

namespace App\Templates;

use Linna\Mvc\TemplateInterface;

/**
 * Html Page Template
 */
class HtmlAjaxTemplate implements TemplateInterface
{
    protected $template = null;
    
    public $data = null;
    
    
    public function __construct($template)
    {
        $this->template = $template;
        $this->data = (object) null;
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
        
        //only for debug, return time execution and memory usage
        echo '<!-- Memory: ';
        echo round(xdebug_memory_usage() / 1024, 2) , ' (';
        echo round(xdebug_peak_memory_usage() / 1024, 2) , ') KByte - Time: ';
        echo xdebug_time_index();
        echo ' Seconds -->';
        
        ob_end_flush();
    }
}
