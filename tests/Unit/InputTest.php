<?php namespace Tests\Unit;

/**
 * 
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use PHPUnit\Framework\TestCase;
use Conso\Input;

class InputTest extends TestCase
{

    public function setUp()
    {
        $_SERVER['argv'] = array(
            __FILE__,
            "command:subCommand",
            "option1",
            "option2",
            "-f",
            "--flag",
        );

        $this->input = new Input();
    }
    /**
     * test capture method
     *
     * @return void
     */
    public function testCaptureMethodIsCapturingInput()
    {
        $this->assertInternalType("array", $this->input->commands);
        $this->assertInternalType("array", $this->input->options);
        $this->assertInternalType("array", $this->input->flags);
    }

    /**
     * test input command and subcommand method
     *
     * @return void
     */
    public function testInputCommandAndSubCommand()
    {
        $this->assertEquals("command", $this->input->commands(0));
        $this->assertEquals("subCommand", $this->input->commands(1));
    }

    /**
     * test input options method
     *
     * @return void
     */
    public function testInoutOptions()
    {
        $this->assertEquals("option1", $this->input->options(0));
        $this->assertEquals("option2", $this->input->options(1));
    }

    /**
     * test input flags method
     * both single and multidahsed words are considered as flags
     *
     * @return void
     */
    public function testInputFlags()
    {
        $this->assertEquals("-f", $this->input->flags(0));
        $this->assertEquals("--flag", $this->input->flags(1));
    }

    /**
     * test not found command
     * if not found return an array
     *
     * @return void
     */
    public function testInputCommandNotFound()
    {
        $this->assertFalse($this->input->commands(5));
    }
}