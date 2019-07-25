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

use Conso\Exceptions\NotFoundException;
use Conso\Output;
use PHPUnit\Framework\TestCase;

/**
 * definging own stearm filter to capture stdout stream.
 */
class ConsoStreamFilter extends \php_user_filter
{
    public static $buffer = '';

    public function filter($in, $out, &$consumed, $closing)
    {
        while ($bucket = stream_bucket_make_writeable($in)) {
            self::$buffer .= $bucket->data;
            $consumed += $bucket->datalen;
        }

        return PSFS_PASS_ON;
    }
}
stream_filter_register('ConsoStreamFilter', ConsoStreamFilter::class);

class OutputTest extends TestCase
{
    /**
     * stream filter.
     *
     * @var resource
     */
    private $stream_filter;

    public function setUp() : void
    {
        $this->output = new Output();

        ConsoStreamFilter::$buffer = '';

        $this->stream_filter = stream_filter_append(STDOUT, 'ConsoStreamFilter');
    }

    /**
     * remove stream filter.
     *
     * @return void
     */
    public function tearDown() : void
    {
        stream_filter_remove($this->stream_filter);
    }

    /**
     * test output to STDOUT.
     *
     * @return void
     */
    public function testOutputWrtiteLineMethod()
    {
        $this->output->writeLn('hello world');
        $this->assertEquals('hello world', ConsoStreamFilter::$buffer);
    }

    /**
     * test output with no color.
     *
     * @return void
     */
    public function testOutputWrongColor()
    {
        $this->expectException(NotFoundException::class);
        $this->output->writeLn('10', 'nocolor');
    }

    /**
     * test output with a background color
     * that doesn't exists.
     *
     * @return void
     */
    public function testOutputWrongBgColor()
    {
        $this->expectException(NotFoundException::class);
        $this->output->writeLn('10', 'white', 'nobgcolor');
    }

    /**
     * test timer output method.
     *
     * @return void
     */
    public function testOutputTimerMethod()
    {
        $this->output->timer();
        $this->assertEquals('[#####################]', ConsoStreamFilter::$buffer);
    }

    /**
     * test white space output method.
     *
     * @return void
     */
    public function testOutputWiteSpaceMethod()
    {
        $this->output->whiteSpace(5);
        $this->assertEquals('     ', ConsoStreamFilter::$buffer);
    }
}
