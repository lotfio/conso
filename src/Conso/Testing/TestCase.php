<?php

namespace Conso\Testing;

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

use Conso\Output;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

class TestCase extends PHPUnitTestCase
{
    /**
     * output.
     *
     * @var object
     */
    protected $output;

    /**
     * set up.
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->output = new Output();
        $this->output->disableAnsi();
        $this->output->enableTestMode();
    }
}