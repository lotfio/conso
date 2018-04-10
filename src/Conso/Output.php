<?php namespace Conso;

use Conso\Contracts\OutputInterface;
use Conso\Exceptions\OutputException;

/**
 * This class is responsible for output and output
 * formatting
 */
class Output implements OutputInterface
{
    /**
     * colors
     *
     * @var array
     */
    private $colors = [
        'white'  => '37',
        'green'  => '32',
        'yellow' => '33',
        'blue'   => '34',
        'black'  => '30',
        'red'    => '31',
    ];

    /**
     * background colors
     *
     * @var array
     */
    private $bg = [
        'white'  => 47,
        'red'    => 41,
        'yellow' => 43,
        'green'  => 42,
        'blue'   => 44,
        'black'  => 40,
        'trans'  => 48, // transparent
    ];

    /**
     * write line method.
     *
     * @param string $line
     * @param string $color
     * @param string $bg
     * @param int    $bold
     */
    public function writeLn(string $line, string $color = 'white', string $bg = 'trans', int $bold = 0)
    {
        $str   = $this->lineFormatter($line, $color, $bg, $bold);
        return fwrite(STDOUT, $str, strlen($str));
    }

    /**
     * output line formatter
     *
     * @return void
     */
    public function lineFormatter(string $line, string $color, string $bg, int $bold) // needs to check if colors exists and staff & validate is256 not testing & supported
    {

        if(!array_key_exists($color, $this->colors))
            throw new OutputException("$color color is not a defined color");

        if(!array_key_exists($bg, $this->bg))
            throw new OutputException("$color background color is not a defined color");

        if(!$this->is256())
            return $line;

        return "\e[".$bold.';'.$this->colors[$color].';'.$this->bg[$bg].'m'.$line."\e[0m";
    }

    /**
     * output success message
     *
     * @param string $msg
     * @return void
     */
    public function success(string $msg)
    {
        $this->writeLn("\n" . $msg . "\n", "green");
    }

    /**
     * exception output
     *
     * @return void
     */
    public function exception(\Exception $e, $env = 0) : void
    {
        $class = get_class($e);

        // output error in dev
        if(php_sapi_name() == 'cli') // if cli
        {
            if($env == 1)
            {
                $this->writeLn("=>\n", "yellow");
                $this->writeLn(" - error    : ", "yellow");$this->writeLn(" {$class}\n"          , "red");
                $this->writeLn(" - message  : ", "yellow");$this->writeLn(" {$e->getMessage()}\n", "red");
                $this->writeLn(" - file     : ", "yellow");$this->writeLn(" {$e->getFile()}\n"   , "red");
                $this->writeLn(" - line     : ", "yellow");$this->writeLn(" {$e->getLine()}\n"   , "red");
                $this->writeLn("=>", "yellow");
                return;
            }
            // output error in production
            $max = max([strlen($e->getMessage()), strlen($class)]) + 8; // get max
            $this->writeLn("\n" .str_repeat(" ", $max + 6) . "\n", 'white', 'red');
            $this->writeLn("    [{$class}]", 'white', 'red');
            $this->writeLn(str_repeat(" ", $max - strlen($class)) . "\n", 'white', 'red');
            $this->writeLn("      {$e->getMessage()}", 'white', 'red');
            $this->writeLn(str_repeat(" ", $max - strlen($e->getMessage())) . "\n", 'white', 'red');
            $this->writeLn(str_repeat(" ", $max + 6) . "\n", 'white', 'red');
            return;
        }
    }

    /**
     * check if terminal supports 256
     *
     * @return boolean
     */
    public function is256() : bool
    {
        if(DIRECTORY_SEPARATOR == '\\') // windows
            return function_exists('sapi_windows_vt100_support') && @sapi_windows_vt100_support(STDOUT);

        return strpos(getenv('TERM'), '256color') !== false;
    }

    /**
     * clear line method
     *
     * @return void
     */
    public function clearLine()
    {
        $cls   =  "\r";//"\033[5D\r";  or "\033[2K\r";
        return fwrite(STDOUT, $cls, strlen($cls));
    }

    /**
     * timer method
     *
     * TODO :: need more work to make percentage works correctly
     *
     * @return void
     */
    public function timer($ms = 60000)
    {
        $str = ">";

        $b = 50;

        for ($i = 0; $i <= 50; $i++) {

            $str = '=' . $str;

            $this->clearLine();

            $this->writeLn("[" . $str . str_repeat(' ', $b) . "] [".($i * 2)."%]");

            usleep($ms);

            $b--;
        }

    }
}