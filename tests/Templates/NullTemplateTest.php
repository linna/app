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

use App\Templates\NullTemplate;
use PHPUnit\Framework\TestCase;

/**
 * Null Template Test
 *
 */
class NullTemplateTest extends TestCase
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
        self::$template = new NullTemplate();
    }

    /**
     * Test new instance.
     *
     * @return void
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(NullTemplate::class, self::$template);
    }

    /**
     * Test output.
     *
     * @return void
     */
    public function testOutput(): void
    {
        self::$template->setData(['test'=>'value']);

        $this->assertEquals('', self::$template->getOutput());
    }
}
