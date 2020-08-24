<?php

namespace Tests\Unit\Commands;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.9.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Testing\TestCase;

class CompileTest extends TestCase
{
    public function testOut()
    {
        $this->assertSame("hello", $this->output->writeLn("hello"));
    }
}