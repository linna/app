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

use Linna\App\Templates\JsonTemplate;
use PHPUnit\Framework\TestCase;

/**
 * Json emplate Test
 *
 */
class JsonTemplateTest extends TestCase
{
    /** @var TemplateInterface Template. */
    protected static $template;

    /**
     * Set up before class.
     *
     * @return void
     */
    public static function setUpBeforeClass(): void
    {
        self::$template = new JsonTemplate();
    }

    /**
     * Test new instance.
     *
     * @return void
     */
    public function testNewInstance(): void
    {
        $this->assertInstanceOf(JsonTemplate::class, self::$template);
    }

    /**
     * Test output.
     *
     * @return void
     */
    public function testOutput(): void
    {
        self::$template->setData(['test' => 'value']);

        $this->assertEquals('{"test":"value"}', self::$template->getOutput());
    }
}
