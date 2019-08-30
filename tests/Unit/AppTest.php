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

use Conso\App;
use Conso\Exceptions\CommandNotFoundException;
use Conso\Exceptions\FlagNotFoundException;
use Conso\Input;
use Conso\Output;
use OoFile\Conf;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
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
        $this->Output = new Output();
        $this->app = new App($this->input, $this->Output);
    }

    /**
     * wrong command.
     *
     * @return void
     */
    public function testBindMethodWrongCommand()
    {
        $this->input->commands[0] = 'noCommand';
        $this->expectException(CommandNotFoundException::class);
        $this->app->bind();
    }

    /**
     * wrong command.
     *
     * @return void
     */
    public function testBindMethodWrongFlags()
    {
        $this->input->flags[0] = '--flag0';
        $this->expectException(FlagNotFoundException::class);
        $this->app->bind();
    }
}
