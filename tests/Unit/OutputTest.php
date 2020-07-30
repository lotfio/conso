<?php

namespace Tests\Unit;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.8.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Output;
use PHPUnit\Framework\TestCase;

class OutputTest extends TestCase
{
    /**
     * output.
     *
     * @var object
     */
    private $output;

    /**
     * set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->output = new Output();
        $this->output->enableTestMode(); // disable write to STDOUT useful for testing
        $this->output->disableAnsi();   // disable ansi no colors needed
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
}
