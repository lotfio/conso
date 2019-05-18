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
use Conso\Exceptions\{CommandNotFoundException, FlagNotFoundException};
use Conso\App;
use Conso\Input;
use Conso\Output;
use Conso\Config;


class AppTest extends TestCase
{
	/**
     * stream filter
     *
     * @var resource
     */
    private $stream_filter;

	
	public function setUp() : void
	{
		Config::load();
		
		$this->input  = new Input();
		$this->Output = new Output();
		$this->app    = new App($this->input, $this->Output);
	}

	/**
	 * wrong commad 
	 * 
	 * @return void
	 */
	public function testBindMethodWrongCommand()
	{
		$this->input->commands[0] = "noCommand";
		$this->expectException(CommandNotFoundException::class);
		$this->app->bind();
	}

	/**
	 * wrong commad 
	 * 
	 * @return void
	 */
	public function testBindMethidWrongflags()
	{
		$this->input->flags[0] = "--flag0";
		$this->expectException(FlagNotFoundException::class);
		$this->app->bind();
	}
}