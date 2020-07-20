<?php

namespace Tests\Unit;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.0.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Input;
use PHPUnit\Framework\TestCase;

class InputTest extends TestCase
{
    /**
     * input.
     *
     * @var object
     */
    private $input;

    /**
     * setting up input.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->input = new Input('make:controller user --crud');
    }

    /**
     * test input command.
     *
     * @return void
     */
    public function testInputCommand()
    {
        $this->assertEquals(
            'make',
            $this->input->command()
        );
    }

    /**
     * test input command.
     *
     * @return void
     */
    public function testInputSubCommand()
    {
        $this->assertEquals(
            'controller',
            $this->input->subCommand()
        );
    }

    /**
     * test input options.
     *
     * @return void
     */
    public function testInputOptions()
    {
        $this->assertContains('user', $this->input->options());
        $this->assertEquals(
            'user',
            $this->input->option(0)
        );
    }

    /**
     * test input options.
     *
     * @return void
     */
    public function testInputFlags()
    {
        $this->assertContains('--crud', $this->input->flags());
        $this->assertEquals(
            '--crud',
            $this->input->flag(0)
        );
    }
}
