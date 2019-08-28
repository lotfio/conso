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
use Conso\Config;
use Conso\Exceptions\CommandNotFoundException;
use Conso\Exceptions\FlagNotFoundException;
use Conso\Input;
use Conso\Output;
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
        Config::load();
        Config::load(); // load config
        Config::appName();
        Config::appVersion();
        Config::appRelease();
        Config::appLogo();
        Config::appDefaultCommand();

        $this->input = new Input();
        $this->Output = new Output();
        $this->app = new App($this->input, $this->Output);
    }

    /**
     * wrong commad.
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
     * wrong commad.
     *
     * @return void
     */
    public function testBindMethidWrongflags()
    {
        $this->input->flags[0] = '--flag0';
        $this->expectException(FlagNotFoundException::class);
        $this->app->bind();
    }
}
