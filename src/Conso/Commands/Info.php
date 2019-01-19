<?php namespace Conso\Commands;

/**
 * 
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command;
use Conso\Contracts\CommandInterface;

class Info extends Command implements CommandInterface
{
    /**
     * execute command and sub commands
     *
     * @param  string $commands
     * @return void
     */
    public function execute($subCommand, $options, $flags) //here rather then found commands we pass the commands in others we pas the sub command
    {   
        $this->logo();
        $this->basicInfo();
        $this->displayAvailableCommands(); // from parent
    }

    /**
     * output app loglo method
     *
     * @return void
     */
    public function logo()
    {
        $this->output->writeLn("     ,gggg,                                                  
   ,88\"\"\"Y8b,                                                
  d8\"     `Y8                                                
 d8'   8b  d8                                                
,8I    \"Y88P'                                                
I8'            ,ggggg,    ,ggg,,ggg,     ,g,       ,ggggg,   
d8            dP\"  \"Y8ggg,8\" \"8P\" \"8,   ,8'8,     dP\"  \"Y8ggg
Y8,          i8'    ,8I  I8   8I   8I  ,8'  Yb   i8'    ,8I  
`Yba,,_____,,d8,   ,d8' ,dP   8I   Yb,,8'_   8) ,d8,   ,d8'  
  `\"Y8888888P\"Y8888P\"   8P'   8I   `Y8P' \"YY8P8PP\"Y8888P\"    \n 
");
    }
    
    /**
     * display basic app infp method
     *
     * @return void
     */
    public function basicInfo()
    {
        $this->output->writeLn(APP_NAME, 'yellow');
        $this->output->writeLn(" version ".APP_VERSION);
        $this->output->writeLn(" " .APP_RELEASE_DATE."\n\n", "green");
        $this->output->writeLn("Usage :\n\n", 'yellow');
        $this->output->writeLn("  command:subcommand [options] [flags] \n\n");
        $this->output->writeLn("Options, flags :\n\n", 'yellow');
        $this->optionsAndFlags("-h, --help", "           Display this help message");
        $this->optionsAndFlags("-q, --quiet", "          Do not output any message");
        $this->optionsAndFlags("-v, --version", "        Display this application version");
        $this->optionsAndFlags("    --ansi", "           Enable ANSI output");
        $this->optionsAndFlags("    --no-ansi", "        Disable ANSI output");
        $this->optionsAndFlags("-n, --no-interaction", " Do not ask any interactive question");
        $this->optionsAndFlags("    --profile", "        Display timing and memory usage information\n");
    }

    /**
     * display default options and flags
     *
     * @param  string $options
     * @param  string $message
     * @return void
     */
    public function optionsAndFlags($options, $message)
    {
        $this->output->writeLn("  $options", 'green');
        $this->output->writeLn("       ");
        $this->output->writeLn("$message\n");
    }

    /**
     * display application version
     *
     * @return void
     */
    public function version()
    {
        $this->output->writeLn("\n".APP_NAME, 'yellow');
        $this->output->writeLn(" version ".APP_VERSION);
        $this->output->writeLn(" " .APP_RELEASE_DATE."\n", "green");
        exit(1);
    }
    
    /**
     * display command description
     *
     * @return void
     */
    public function description(){return "Display this help message !";}
}