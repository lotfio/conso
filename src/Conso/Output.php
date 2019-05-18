<?php namespace Conso;

/**
 * @author    <contact@lotfio.net>
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Config;
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\NotFoundException;

class Output implements OutputInterface
{
    private $colors = [
    'white' => '37',
    'green' => '32',
    'yellow' => '33',
    'blue' => '34',
    'black' => '30',
    'red' => '31',
    ];

    private $bgColors = [
    'white' => 47,
    'red' => 41,
    'yellow' => 43,
    'green' => 42,
    'blue' => 44,
    'black' => 40,
    'trans' => 48, // transparent
    ];

    /**
     * Undocumented function.
     *
     * @param string $line
     * @param string $color
     * @param string $bg
     * @param int    $bold
     */
    public function writeLn(string $line, string $color = 'white', string $bg = 'trans', int $bold = 0)
    {
        return fwrite(STDOUT, $this->outputFormater($line, $color, $bg, $bold));
    }

    /**
     * output error message.
     *
     * @param string $msg
     */
    public function error($msg)
    {
        $this->writeLn("\n".$msg."\n\n", 'white', 'red', 1);
    }

    /**
     * output warning message.
     *
     * @param string $msg
     */
    public function warning($msg)
    {
        return $this->writeLn("\n".$msg.' ', 'white', 'yellow', 1);
    }

    /**
     * output success message.
     *
     * @param string $msg
     */
    public function success($msg)
    {
        return $this->writeLn("\n".$msg.' ', 'white', 'green', 1);
    }
    
    /**
     * Otput timer.
     *
     * @param int $ms delay in seconds
     */
    public function timer($ms = 5000)
    {
        $this->writeLn('[');
        for ($i = 0; $i <= 20; ++$i) {
            $this->writeLn('#');
            usleep($ms);
        }
        $this->writeLn(']');
    }

    /**
     * writing white spaces method.
     *
     * @param int $number
     */
    public function whiteSpace($number)
    {
        for ($i = 0; $i < $number; ++$i) {
            $this->writeLn(' ');
        }
    }

    /**
     * output forrmatter.
     *
     * @param string $line
     * @param string $color
     * @param string $bg
     * @param int    $bold
     */
    private function outputFormater(string $line, string $color, string $bg, int $bold)
    {
        if (!isset($this->colors[$color])) {
            throw new NotFoundException('error color not found');
        }
        if (!isset($this->bgColors[$bg])) {
            throw new NotFoundException('error background color not found');
        }
        if ((Config::get('OS') != 'WINNT') && !isTest() && inp()->flags(0) != "--no-ansi") { // if not windows -a
            return "\e[".$bold.';'.$this->colors[$color].';'.$this->bgColors[$bg].'m'.$line."\e[0m";
        }

        return $line;
    }
}
