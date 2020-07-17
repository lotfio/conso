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

use Conso\CommandsTable;
use PHPUnit\Framework\TestCase;

class CommandsTableTest extends TestCase
{
    /**
     * commands table
     *
     * @var object
     */
    private $table;

    /**
     * set up command
     *
     * @return void
     */
    public function setUp() : void
    {
        $this->table = new CommandsTable;
    }

    /**
     * test command name
     *
     * @return void
     */
    public function testCommandName()
    {
        $this->table->add('test', NULL);
        $this->assertEquals(
            $this->table->getCommands()[0]['name'],
            'test'
        );
    }

    /**
     * test command action
     *
     * @return void
     */
    public function testCommandAction()
    {
        $this->table->add('test', 'command');
        $this->assertEquals(
            $this->table->getCommands()[0]['action'],
            'command'
        );
    }

    /**
     * test sub command
     *
     * @return void
     */
    public function testSubCommand()
    {
        $this->table->add('test', 'command')->sub(['sub1']);
        $this->assertContains(
            'sub1',
            $this->table->getCommands()[0]['sub']
        );
    }

    /**
     * test command flags
     *
     * @return void
     */
    public function testCommandFlags()
    {
        $this->table->add('test', 'command')->flags(['--yes']);
        $this->assertContains(
            '--yes',
            $this->table->getCommands()[0]['flags']
        );
    }

    /**
     * test command aliases
     *
     * @return void
     */
    public function testCommandAlias()
    {
        $this->table->add('test', 'command')->alias(['com']);
        $this->assertContains(
            'com',
            $this->table->getCommands()[0]['aliases']
        );
    }

    /**
     * test command aliases
     *
     * @return void
     **/
    public function testCommandDescription()
    {
        $this->table->add('test', 'command')->description('This is a command');
        $this->assertSame(
            $this->table->getCommands()[0]['description'],
            'This is a command',
        );
    }
    /*
     * test command aliases
     *
     * @return void
     */
    public function testCommandHelp()
    {
        $this->table->add('test', 'command')->help(['command help']);
        $this->assertContains(
            'command help',
            $this->table->getCommands()[0]['help']
        );
    }
}