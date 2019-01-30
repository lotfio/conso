<?php namespace Conso\Commands;

/**
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command as BaseCommand;
use Conso\Contracts\CommandInterface;
use Conso\Exceptions\OptionNotFoundException;
use Conso\Exceptions\RunTimeException;

class Command extends BaseCommand implements CommandInterface
{
    /**
     * command flags
     * 
     * @var array
     */
    protected $flags = [];

    /**
     * command execute method
     * 
     * @param  string $sub
     * @param  array  $options
     * @param  array  $flags
     * @return void
     */
    public function execute($sub, $options, $flags)
    {
        if(!empty($sub))
        {        
            switch ($sub) {

                case 'make'  : die($this->makeNewCommand($options)); break;
                case 'delete': die($this->deleteCommand($options)); break;
                
                default: throw new RunTimeException("Error sub command not recognized ! "); break;
            }
        }

       $this->help();
    }

    
    /**
     * make new command method
     * 
     * @param  string $options
     * @return void
     */
    public function makeNewCommand($options)
    {
        if(!isset($options[0]) || empty($options[0])) throw new OptionNotFoundException("Command Name is required ! ");
        
    
        $name =  ucfirst(strtolower($options[0]));
        $stubFile = COMMANDS . "Helpers" . DS . "Stubs" . DS . 'Command.stub';

        if(!file_exists($stubFile)) throw new RunTimeException("Error file $stubFile not found");
        
        if(file_exists(COMMANDS . $name . ".php")) throw new RunTimeException("Error command $name already exists !");

        $file = file_get_contents($stubFile);

        $file = str_replace("#command#", $name, $file);
        $file = str_replace("#time#", date('d-m-Y'), $file);

        $commandHundle  = fopen(COMMANDS . $name . '.php', "w+");

        if(fwrite($commandHundle, $file))
        {   
            $this->output->writeLn("\n Generating command file : ", "green");
            $this->output->timer();
            $this->output->writeLn("\n\n");
            exit(1);
        }

        throw new RunTimeException("Error making command !");
    }

    /**
     * delete command method
     * 
     * @param  array $options
     * @return void
     */
    public function deleteCommand($options)
    {
        if(!isset($options[0]) || empty($options[0])) throw new OptionNotFoundException("Command Name is required ! ");
        
        $name =  ucfirst($options[0]);
        $command = COMMANDS . $name . ".php";

        if(!file_exists($command)) throw new RunTimeException("Error command $name not found !");

        $ask = readline("\n are you sure you want to delete $name command ? [Y/N] : ");
        

        if(strtolower($ask) == "y" OR strtolower($ask) == "yes")
        {   
            unlink($command);
      
            $this->output->writeLn("\n Command $name deleted successfully : ", "green");
            $this->output->timer();
            $this->output->writeLn("\n\n");
            exit(1);

        }
        
        $this->output->writeLn("\n abbroting : command not deleted \n\n", "yellow");
    }




    /**
     * command description method
     *  
     * @return string
     */
    public function help()
    {
       $this->output->writeLn("\n [ command ] \n\n", "yellow");
       $this->output->writeLn("   example command helps you to create commands for your console application.\n\n");
       $this->output->writeLn("  sub commands : \n\n", "yellow");
       $this->output->writeLn("    make    : make a new command.\n");
       $this->output->writeLn("    delete  : delete an existing command.\n\n");
       $this->output->writeLn("  options : \n\n", "yellow");
       $this->output->writeLn("    command name (to be created or deleted).\n\n");
       return "";
    }

    /**
     * command help method
     *  
     * @return string
     */
    public function description()
    {
        return 'Example conso command';
    }
}
