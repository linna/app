<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2017, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace App\Templates;

use Linna\Mvc\TemplateInterface;
use stdClass;

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
    public $data;

    /**
     * @var array Css file for template
     */
    protected $css = [];

    /**
     * @var array Js file for template
     */
    protected $javascript = [];

    /**
     * @var string Template directory 
     */
    protected $templateDir;
    
    /**
     * @var string Css directory 
     */
    protected $cssDir;
    
    /**
     * Constructor.
     */
    public function __construct(string $templateDir, string $cssDir)
    {
        $this->data = new stdClass();
        $this->templateDir = $templateDir;
        $this->cssDir = $cssDir;
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
        $this->css[] = $this->cssDir.$file;
    }

    /**
     * Load a file js in to shared template.
     *
     * @param string $file Js file
     */
    public function loadJs(string $file)
    {
        $this->javascript[] = $this->cssDir.$file;
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

        require "{$this->templateDir}/{$this->template}.html";

        return ob_get_clean();
    }
}
