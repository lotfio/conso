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

use Conso\Input;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    public function setUp() : void
    {
        $_SERVER['argv'] = [
            __FILE__,
            'command:subCommand',
            'option1',
            'option2',
            '-f',
            '--flag',
        ];

        $this->input = new Input();
    }

    /**
     * test capture method.
     *
     * @return void
     */
    public function testCaptureMethodIsCapturingInput()
    {
        $this->assertIsArray($this->input->commands);
        $this->assertIsArray($this->input->options);
        $this->assertIsArray($this->input->flags);
    }

    /**
     * test input command and subcommand method.
     *
     * @return void
     */
    public function testInputCommandAndSubCommand()
    {
        $this->assertEquals('command', $this->input->commands(0));
        $this->assertEquals('subCommand', $this->input->commands(1));
    }

    /**
     * test input options method.
     *
     * @return void
     */
    public function testInputOptions()
    {
        $this->assertEquals('option1', $this->input->options(0));
        $this->assertEquals('option2', $this->input->options(1));
    }

    /**
     * test input flags method
     * both single and multi dashed words are considered as flags.
     *
     * @return void
     */
    public function testInputFlags()
    {
        $this->assertEquals('-f', $this->input->flags(0));
        $this->assertEquals('--flag', $this->input->flags(1));
    }

    /**
     * test not found command
     * if not found return an array.
     *
     * @return void
     */
    public function testInputCommandNotFound()
    {
        $this->assertFalse($this->input->commands(5));
    }
}
