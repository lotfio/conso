<?php namespace Conso;

use Conso\Contracts\OutputInterface;

/**
 * 
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

class Output implements OutputInterface
{
    private $colors   = [
    "white"  => "37",
    "green"  => "32",
    "yellow" => "33",
    "blue"   => "34",
    "black"  => "30",
    "red"    => "31"
    ];

    private $bgColors = [
    "white" => 47,
    "red"   => 41,
    "yellow"=> 43,
    "green" => 42,
    "blue"  => 44,
    "black" => 40
    ];


    /**
     * Undocumented function
    *
    * @param string  $line
    * @param string  $color
    * @param string  $bg
    * @param integer $bold
    * @return void
    */
    public function writeLn(string $line, string $color = 'white', string $bg = "black", int $bold = 0)
    {
        return fwrite(STDOUT, $this->outputFormater($line, $color, $bg, $bold)); 
    }

    /**
     * output error message
     *
     * @param  string $msg
     * @return void
     */
    public function error($msg)
    {
        return exit($this->writeLn("\n" . $msg . "\n\n", "white", "red", 1));
    }

    /**
     * output warning message
     *
     * @param  string $msg
     * @return void
     */
    public function warning($msg)
    {
        return $this->writeLn("\n" . $msg . " ", "white", "yellow", 1);
    }
    
    /**
     * output success message
     *
     * @param  string $msg
     * @return void
     */
    public function success($msg)
    {
        return $this->writeLn("\n" . $msg . " ", "white", "green", 1);
    }

    /**
     * Otput timer
     *
     * @param  integer $ms delay in seconds
     * @return void
     */
    public function timer($ms = 5000)
    {
        $this->writeLn("[");
        for($i = 0; $i <= 20; $i++)
        {
            $this->writeLn("#");
            usleep($ms);
        }
        $this->writeLn("]");
    }

    public function whiteSpace($number)
    {
        for ($i=0; $i < $number; $i++) { 
            $this->writeLn(" ");
        }
    }
    /**
     * output forrmatter
     *
     * @param string $line
     * @param string $color
     * @param string $bg
     * @param integer $bold
     * @return void
     */
    public function outputFormater(string $line, string $color, string $bg, int $bold)
    {
        if(!isset($this->colors[$color])) exit("error color not found");
        if(!isset($this->bgColors[$bg]))  exit("error background color not found");
        return "\e[". $bold .";" . $this->colors[$color] . ";" . $this->bgColors[$bg] . "m" . $line . "\e[0m";
    }
}