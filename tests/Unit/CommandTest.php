<?php

namespace Tests\Unit;

/*
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command;
use Conso\Config;
use Conso\Exceptions\FlagNotFoundException;
use Conso\Input;
use Conso\Output;
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
        Config::load();

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
    public function testcommandWhiteSpaceLengthMethod()
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
    public function testdisplayAvailableCommandsMethod()
    {
        $this->command->displayAvailableCommands();
        $this->assertRegexp('/vailable commands :/', ConsoStreamFilter::$buffer);
    }

    /**
     * test list commands method.
     *
     * @return array
     */
    public function testlistCommandsMethod()
    {
        $this->assertIsArray($this->command->listCommands());
        $this->assertArrayHasKey('info', $this->command->listCommands());
    }

    /**
     * test check flags when not defined in the command class.
     *
     * @return void | throw exception
     */
    public function testcheckFlagsMethodNoFlagsFound()
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
    public function testcheckFlagsMethodFlagIsDefined()
    {
        $this->input->flags[0] = '--test';
        $this->assertNull($this->command->checkFlags(['--test']));
    }
}
