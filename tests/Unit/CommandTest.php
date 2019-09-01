<?php

namespace Tests\Unit;

/*
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.2.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command;
use Conso\Exceptions\FlagNotFoundException;
use Conso\Input;
use Conso\Output;
use OoFile\Conf;
use PHPUnit\Framework\TestCase;

class CommandTest extends TestCase
{
    /**
     * stream filter.
     *
     * @var resource
     */
    private $stream_filter;

    public function setUp() : void
    {
        Conf::add(dirname(__DIR__, 2).'/src/Conso/conf');

        $this->input = new Input();
        $this->command = new Command($this->input, new Output());

        ConsoStreamFilter::$buffer = '';

        $this->stream_filter = stream_filter_append(STDOUT, 'ConsoStreamFilter');
    }

    /**
     * test version method.
     *
     * @return void
     */
    public function testVersionMethod()
    {
        $this->command->version();
        $this->assertRegexp('/version/', ConsoStreamFilter::$buffer);
    }

    /**
     * test white spaces method.
     *
     * @return array
     */
    public function testCommandWhiteSpaceLengthMethod()
    {
        // example -----    => example needs 5 spaces to get correctly aligned
        // info --------    => info needs 8 spaces to get correctly aligned
        $this->assertEquals(5, $this->command->commandWhiteSpaceLength(0));
        $this->assertEquals(8, $this->command->commandWhiteSpaceLength(1));
    }

    /**
     * test display available commands method.
     *
     * @return
     */
    public function testDisplayAvailableCommandsMethod()
    {
        $this->command->displayAvailableCommands();
        $this->assertRegexp('/Available commands :/', ConsoStreamFilter::$buffer);
    }

    /**
     * test list commands method.
     *
     * @return array
     */
    public function testListCommandsMethod()
    {
        $this->assertIsArray($this->command->readCommands());
        $this->assertArrayHasKey('Info', $this->command->readCommands());
    }

    /**
     * test check flags when not defined in the command class.
     *
     * @return void | throw exception
     */
    public function testCheckFlagsMethodNoFlagsFound()
    {
        $this->input->flags[0] = '--test';

        $this->expectException(FlagNotFoundException::class);
        $this->command->checkFlags();
    }

    /**
     * test check flags defined.
     *
     * @return void
     */
    public function testCheckFlagsMethodFlagIsDefined()
    {
        $this->input->flags[0] = '--test';
        $this->assertNull($this->command->checkFlags(['--test']));
    }
}
