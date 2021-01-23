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

use Conso\Output;
use Conso\Testing\TestCase;

class OutputTest extends TestCase
{
    /**
     * set up.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * test output write ln.
     *
     * @return void
     */
    public function testOutputWriteLn()
    {
        $this->assertEquals(
            'hello',
            $this->output->writeLn('hello')
        );
    }

    /**
     * test output with no verbosity.
     *
     * @return void
     */
    public function testOutputNoVerbosity()
    {
        try {
            throw new \Exception('test exception');
        } catch (\Exception $e) {
            $this->assertFalse(
                $this->output->exception($e)
            );
        }
    }

    /**
     * test output with verbosity.
     *
     * @return void
     */
    public function testOutputVerbosity()
    {
        $this->output->enableVerbosity(); // enable verbosity (dev mode)

        try {
            throw new \Exception('test exception');
        } catch (\Exception $e) {
            $this->assertTrue(
                $this->output->exception($e)
            );
        }
    }
}
