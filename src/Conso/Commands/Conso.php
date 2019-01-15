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

class Conso extends Command
{

    public function capture($options, $flags) // play around with your captured inputs here
    {
    }

    public function execute($action) // execute your actions here and pass your flags
    {
        $this->logo();
    }

    public function description()
    {
        return "This is the command description and details";
    }

    public function logo()
    {
        $this->output->writeLn("   ___                         ___   _   ___  
  / __\___  _ __  ___  ___    / _ \ / | / _ \ 
 / /  / _ \| '_ \/ __|/ _ \  | | | || || | | |
/ /__| (_) | | | \__ \ (_) | | |_| || || |_| |
\____/\___/|_| |_|___/\___/   \___(_)_(_)___/
                                            
");
        $this->output->writeLn(APP_NAME, 'yellow');
        $this->output->writeLn(" version ".APP_VERSION);
        $this->output->writeLn(" released " .APP_RELEASE_DATE);
    }
}