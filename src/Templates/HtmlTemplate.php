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
     * Load a file css in to shared template.
     *
     * @param string $file Css file
     */
    public function loadCss(string $file)
    {
        $this->css[] = URL_STYLE.$file;
    }

    /**
     * Load a file js in to shared template.
     *
     * @param string $file Js file
     */
    public function loadJs(string $file)
    {
        $this->javascript[] = URL_STYLE.$file;
    }

    /**
     * Output.
     */
    public function getOutput() : string
    {
        extract([
            'data'       => $this->data,
            'title'      => $this->title,
            'css'        => $this->css,
            'javascript' => $this->javascript,
        ]);

        ob_start();

        require APP.'src/Templates/_shared/header.html';
        require APP."src/Templates/_pages/{$this->template}.html";
        require APP.'src/Templates/_shared/footer.html';

        return ob_get_clean();
    }
}
