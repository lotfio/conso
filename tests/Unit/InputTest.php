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
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    /**
     * input
     *
     * @var object
     */
    private $input;

    /**
     * setting up input
     *
     * @return void
     */
    public function setUp() : void
    {
        $this->input = new Input("make:controller user --crud");
    }

    /**
     * test input command
     *
     * @return void
     */
    public function testInputCommand()
    {
        $this->assertEquals($this->input->command(), "make");
    }

    /**
     * test input command
     *
     * @return void
     */
    public function testInputSubCommand()
    {
        $this->assertEquals($this->input->subCommand(), "controller");
    }

    /**
     * test input options
     *
     * @return void
     */
    public function testInputOptions()
    {
        $this->assertContains('user', $this->input->options());
        $this->assertEquals($this->input->option(0), "user");
    }

    /**
     * test input options
     *
     * @return void
     */
    public function testInputFlags()
    {
        $this->assertContains('--crud', $this->input->flags());
        $this->assertEquals($this->input->flag(0), "--crud");
    }
}