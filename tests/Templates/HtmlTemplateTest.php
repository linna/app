<?php

/**
 * Linna App.
 *
 * @author Sebastian Rapetti <sebastian.rapetti@alice.it>
 * @copyright (c) 2018, Sebastian Rapetti
 * @license http://opensource.org/licenses/MIT MIT License
 */
declare(strict_types=1);

namespace Linna\Tests;

use App\Templates\HtmlTemplate;
use Linna\Mvc\TemplateInterface;
use PHPUnit\Framework\TestCase;

/**
 * Html Template Test
 *
 */
class HtmlTemplateTest extends TestCase
{
    /**
     * @var TemplateInterface Template.
     */
    protected static $template;

    /**
     * Set up before class.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$template = new HtmlTemplate(
            __DIR__.'/../TestHelper/html/',
            __DIR__.'/../TestHelper/css/',
            __DIR__.'/../TestHelper/js/'
        );
    }

    /**
     * Test new instance.
     *
     * @return void
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(HtmlTemplate::class, self::$template);
    }

    /**
     * Test output.
     *
     * @return void
     */
    public function testOutput(): void
    {
        self::$template->loadHtml('testPage');
        self::$template->setData(['test'=>'value']);

        $this->assertEquals('<b>value</b>', self::$template->getOutput());
    }
}
