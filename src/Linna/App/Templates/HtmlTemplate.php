<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@tim.it>
 * @copyright (c) 2020, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\App\Templates;

use Linna\Mvc\TemplateInterface;
use stdClass;

/**
 * Html Page Template.
 */
class HtmlTemplate implements TemplateInterface
{
    /** @var string Template to load */
    protected $template = null;

    /** @var string Template Title */
    public $title = 'App';

    /** @var object Data for template */
    public $data;

    /** @var array Css file for template */
    protected $css = [];

    /** @var array Js file for template */
    protected $javascript = [];

    /** @var string Template directory */
    protected $templateDir;

    /** @var string Css directory */
    protected $cssDir;

    /** @var string Js directory */
    protected $jsDir;

    /**
     * Constructor.
     *
     * @param string $templateDir Direcotry for html templates.
     * @param string $cssDir      Direcotry for css files.
     * @param string $jsDir       Direcotry for javascript files.
     */
    public function __construct(string $templateDir, string $cssDir, string $jsDir)
    {
        $this->data = new stdClass();
        $this->templateDir = $templateDir;
        $this->cssDir = $cssDir;
        $this->jsDir = $jsDir;
    }

    /**
     * Load html file.
     *
     * @param string $file Html file
     */
    public function loadHtml(string $file): void
    {
        $this->template = $file;
    }

    /**
     * Load a file css in to shared template.
     *
     * @param string $file Css file
     */
    public function loadCss(string $file): void
    {
        $this->css[] = $this->cssDir.$file;
    }

    /**
     * Load a file js in to shared template.
     *
     * @param string $file Js file
     */
    public function loadJs(string $file): void
    {
        $this->javascript[] = $this->jsDir.$file;
    }

    /**
     * Set the output data.
     *
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = (object) $data;
    }

    /**
     * Output.
     */
    public function getOutput(): string
    {
        \extract([
            'data'       => $this->data,
            'title'      => $this->title,
            'css'        => $this->css,
            'javascript' => $this->javascript,
        ]);

        \ob_start();

        require "{$this->templateDir}{$this->template}.html";

        return \ob_get_clean();
    }
}
