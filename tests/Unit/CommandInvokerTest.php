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
use Conso\Conso;
use Conso\CommandInvoker;
use PHPUnit\Framework\TestCase;
use Conso\Exceptions\InputException;

class CommandInvokerTest extends TestCase
{
    /**
     * output
     *
     * @var object
     */
    private $output;

    /**
     * commands
     *
     * @var array
     */
    private $commands;

    /**
     * set up
     *
     * @return void
     */
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
                'action'        => "Tests\\Unit\\Mocks\\Make",
                'flags'         => ['--form'],
                'description'   => 'This is make command',
                'help'          => []
            )
        );
    }

    /**
     * test invoke callback
     *
     * @return void
     */
    public function testInvokeCallback()
    {
        $this->commands[0]['action'] = function(){ return 'from make callback'; };

        $inp     = new Input('make');
        $invoker = new CommandInvoker($inp, $this->output, new Conso($inp, $this->output));

        $this->assertEquals(
            'from make callback',
            $invoker->invoke($this->commands[0])
        );
    }

    /**
     * test invoke class method
     *
     * @return void
     */
    public function testInvokeClassMethod()
    {
        $inp     = new Input('make');
        $invoker = new CommandInvoker($inp, $this->output, new Conso($inp, $this->output));

        ob_start();
        $invoker->invoke($this->commands[0]);
        $res = ob_get_clean();

        $this->assertEquals(
            'from make class command',
            $res
        );
    }
}