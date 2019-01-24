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
use Conso\Exceptions\FlagNotFoundException;

class Info extends Command implements CommandInterface
{
    protected $flags = ["-c", "--commands"];
    /**
     * execute command and sub commands
     *
     * @param  string $commands
     * @return void
     */
    public function execute($sub, $options, $flags) //here rather then found commands we pass the commands in others we pas the sub command
    {   
        $this->displayCommands($flags); 
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
        $this->output->writeLn("                                                 
  .g8\"\"\"bgd                                      
.dP'     `M                                      
dM'         ,pW\"Wq.`7MMpMMMb.  ,pP*Ybd  ,pW\"Wq.  
MM         6W'   `Wb MM    MM  8I   `\" 6W'   `Wb 
MM.        8M     M8 MM    MM  `YMMMa. 8M     M8 
`Mb.     ,'YA.   ,A9 MM    MM  L.   I8 YA.   ,A9 
  `*bmmmd'  `Ybmd9'.JMML  JMML.M9mmmP'  `Ybmd9' \n\n");


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
        $this->optionsAndFlags("-c, --commands", "       Display available application commands");
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
     * display basic help
     *
     * @return void
     */
    public function help(){

        $this->output->writeLn("\n[ Info ]\n\n", 'yellow');
        $this->basicInfo();
        exit(1);
    }

    /**
     * dispay help commands
     *
     * @param string $flag
     * @return void
     */
    public function displayCommands($flags)
    {
        if($this->input->flags(0))
        {
            if(in_array($flags[0], $this->flags))
            {
                if($flags[0] == "-c" || $flags[0] == "--commands") 
                {
                    $this->output->writeLn("\n");
                    $this->displayAvailableCommands();
                    die;
                }
            }
        }
    }
    
    /**
     * display command description
     *
     * @return void
     */
    public function description(){return "Display this help message !";}
}