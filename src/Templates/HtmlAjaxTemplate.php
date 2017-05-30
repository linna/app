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
     */
    public function getOutput() : string
    {
        extract(['data' => $this->data]);

        ob_start();

        require APP."Templates/_pages/{$this->template}.html";

        return ob_get_clean();
    }
}
