<?php

/**
 * Linna App.
 *
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */

namespace App\Templates;

use Linna\Mvc\TemplateInterface;

/**
 * Html via Ajax Template.
 */
class HtmlAjaxTemplate implements TemplateInterface
{
    /**
     * @var string Html template to load
     */
    protected $template;

    /**
     * @var object Data for view
     */
    public $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data = (object) null;
    }

    /**
     * Load html file.
     *
     * @param string $file Html file
     */
    public function loadHtml(string $file)
    {
        $this->template = $file;
    }

    /**
     * Output.
     *
     * @throws \InvalidArgumentException
     */
    public function getOutput() : string
    {
        //get template
        $template = $this->template;

        //get data for view
        $data = $this->data;

        ob_start();

        try {
            //check if template name is correct
            if (!file_exists(APP."Templates/_pages/{$template}.html")) {
                throw new \InvalidArgumentException("The required Template ({$template}) not exist.");
            }
            //require template
            require APP."Templates/_pages/{$template}.html";
        } catch (\InvalidArgumentException $e) {
            echo 'Template exception: ', $e->getMessage(), "\n";
        }

        $output = ob_get_contents();
        
        ob_end_clean();
        
        return $output;
    }
}
