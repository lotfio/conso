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

use Conso\Conso;
use Conso\Input;
use Conso\Testing\TestCase;

class ConsoTest extends TestCase
{
    /**
     * set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * test not found command.
     *
     * @return void
     */
    public function testCommandNotFound()
    {
        $this->expectException(\Exception::class);
        $app = new Conso(new Input('test'), $this->output);
        $app->run();
    }

    /**
     * test not found command.
     *
     * @return void
     */
    public function testSubCommandNotFound()
    {
        $this->expectException(\Exception::class);
        $app = new Conso(new Input('test:hello'), $this->output);
        $app->command('test', function () {});
        $app->run();
    }

    /**
     * test flag not found.
     *
     * @return void
     */
    public function testFlagNotFound()
    {
        $this->expectException(\Exception::class);
        $app = new Conso(new Input('test:hello --crud'), $this->output);
        $app->command('test', function () {})->sub('hello');
        $app->run();
    }

    /**
     * test set signature.
     *
     * @return void
     */
    public function testSetSignature()
    {
        $app = new Conso(new Input(), $this->output);
        $app->setSignature('conso');

        $this->assertEquals(
            'conso',
            $app->getSignature()
        );
    }

    /**
     * test set name.
     *
     * @return void
     */
    public function testSetName()
    {
        $app = new Conso(new Input(), $this->output);
        $app->setName('console app');

        $this->assertEquals(
            'console app',
            $app->getName()
        );
    }

    /**
     * test set version.
     *
     * @return void
     */
    public function testSetVersion()
    {
        $app = new Conso(new Input(), $this->output);
        $app->setVersion('1.0.0');

        $this->assertEquals(
            '1.0.0',
            $app->getVersion()
        );
    }

    /**
     * test set author.
     *
     * @return void
     */
    public function testSetAuthor()
    {
        $app = new Conso(new Input(), $this->output);
        $app->setAuthor('lotfio lakehal');

        $this->assertEquals(
            'lotfio lakehal',
            $app->getAuthor()
        );
    }

    /**
     * test set commands path.
     *
     * @return void
     */
    public function testSetCommandsPath()
    {
        $app = new Conso(new Input(), $this->output);
        $app->setCommandsPath('/commands');

        $this->assertEquals(
            '/commands',
            $app->getCommandsPath()
        );
    }

    /**
     * test set commands namespace.
     *
     * @return void
     */
    public function testSetCommandsNamespace()
    {
        $app = new Conso(new Input(), $this->output);
        $app->setCommandsNamespace('Conso\\');

        $this->assertEquals(
            'Conso\\',
            $app->getCommandsNamespace()
        );
    }

    /**
     * test get commands.
     *
     * @return void
     */
    public function testSetGetCommands()
    {
        $app = new Conso(new Input(), $this->output);
        $app->command('test', 'testCommandClass');

        $this->assertContains(
            'test',
            $app->getCommands()[0]
        );
    }
}
