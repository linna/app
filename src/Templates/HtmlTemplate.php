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
 * Html Page Template.
 */
class HtmlTemplate implements TemplateInterface
{
    /**
     * @var string Template to load
     */
    protected $template = null;

    /**
     * @var string Template Title
     */
    public $title = 'App';

    /**
     * @var object Data for template
     */
    public $data = null;

    /**
     * @var array Css file for template
     */
    protected $css = [];

    /**
     * @var array Js file for template
     */
    protected $javascript = [];

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
     * Load a file css to shared template.
     *
     * @param string $file Css file
     */
    public function loadCss(string $file)
    {
        $this->css[] = URL_STYLE.$file;
    }

    /**
     * Load a file js to shared template.
     *
     * @param string $file Js file
     */
    public function loadJs(string $file)
    {
        $this->javascript[] = URL_STYLE.$file;
    }

    /**
     * Prepare template for render from View.
     *
     * @throws \Exception if template path is incorrect
     */
    public function output()
    {
        $template = $this->template;

        $data = $this->data;
        $css = $this->css;
        $javascript = $this->javascript;

        $title = $this->title;

        ob_start();

        try {
            if (!file_exists(APP."src/Templates/_pages/{$template}.html")) {
                throw new \Exception("The required Template ({$template}) not exist.");
            }

            require APP.'src/Templates/_shared/header.html';
            require APP."src/Templates/_pages/{$template}.html";
            require APP.'src/Templates/_shared/footer.html';
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
