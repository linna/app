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

use Linna\App\Templates\RawTemplate;
use PHPUnit\Framework\TestCase;

/**
 * Raw Template Test
 *
 */
class RawTemplateTest extends TestCase
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
        self::$template = new RawTemplate();
    }

    /**
     * Test output.
     *
     * @return void
     */
    public function testOutput(): void
    {
        self::$template->setData(['value1', 'value2', 'value3']);

        $this->assertEquals('value1value2value3', self::$template->getOutput());
    }
}
