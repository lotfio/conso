<?php

namespace Tests\Unit;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   2.0.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\CommandInvoker;
use Conso\Conso;
use Conso\Input;
use Conso\Testing\TestCase;

class CommandInvokerTest extends TestCase
{
    /**
     * commands.
     *
     * @var array
     */
    private $commands;

    /**
     * set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->commands = [
            [
                'name'          => 'make',
                'aliases'       => [],
                'sub'           => ['controller'],
                'action'        => 'Tests\\Unit\\Mocks\\Make',
                'flags'         => ['--form'],
                'description'   => 'This is make command',
                'help'          => [],
                'group'         => 'main',
                'namespace'     => null,
            ],
        ];
    }

    /**
     * test invoke callback.
     *
     * @return void
     */
    public function testInvokeCallback()
    {
        $this->commands[0]['action'] = function () { return 'from make callback'; };

        $inp = new Input('make');
        $app = new Conso($inp, $this->output);
        $invoker = new CommandInvoker($inp, $this->output, $app);

        $this->assertEquals(
            'from make callback',
            $invoker->invoke($this->commands[0])
        );
    }

    /**
     * test invoke class method.
     *
     * @return void
     */
    public function testInvokeClassMethod()
    {
        $inp = new Input('make');
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
