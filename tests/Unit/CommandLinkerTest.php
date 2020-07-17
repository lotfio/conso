<?php namespace Tests\Unit;

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   1.0.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Input;
use Conso\Output;
use Conso\CommandLinker;
use PHPUnit\Framework\TestCase;
use Conso\Exceptions\InputException;

class CommandLinkerTest extends TestCase
{
    private $output;
    private $commands;

    public function setUp() : void
    {
        $this->output = new Output;
        $this->output->disableAnsi();
        $this->output->enableTestMode();

        $this->commands = array(
            array(
                'name'          => 'make',
                'aliases'       => [],
                'sub'           => ['controller'],
                'action'        => "MakeClass",
                'flags'         => ['--form'],
                'description'   => 'This is make command',
                'help'          => []
            )
        );
    }

    /**
     * test link method
     *
     * @return void
     */
    public function testLinkMethodNoCommand()
    {
        $linker = new CommandLinker(new Input, $this->output);
        $link   = $linker->link($this->commands);
        $this->assertEquals(NULL, $link);
    }

    /**
     * test wrong method
     *
     * @return void
     */
    public function testLinkMethodWrongCommand()
    {
        $this->expectException(InputException::class);
        $linker = new CommandLinker(new Input('test'), $this->output);
        $linker->link($this->commands);
    }

    /**
     * test wrong sub command
     *
     * @return void
     */
    public function testLinkMethodWrongSubCommand()
    {
        $this->expectException(InputException::class);
        $linker = new CommandLinker(new Input('make:test'), $this->output);
        $linker->link($this->commands);
    }

    /**
     * test wrong flag
     *
     * @return void
     */
    public function testLinkMethodWrongFlags()
    {
        $this->expectException(InputException::class);
        $linker = new CommandLinker(new Input('make:controller User --escape'), $this->output);
        $linker->link($this->commands);
    }

    /**
     * test linked match
     *
     * @return void
     */
    public function testLinkMethodCommandMatch()
    {
        $linker = new CommandLinker(new Input('make'), $this->output);
        $res    = $linker->link($this->commands);

        $this->assertSame($res, $this->commands[0]);
    }
}