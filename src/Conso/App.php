<?php namespace Conso;

/**
 * 
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\CommandNotFoundException;

class App
{
    /**
     * input
     *
     * @var object
     */
    private $input;

    /**
     * output
     *
     * @var object
     */
    private $output;

    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input   = $input;
        $this->output  = $output;
    }

    /**
     * command bind method
     *
     * @return void
     */
    public function bind() // bind the imput with the exact command and pass options and flags 
    {
        // bind commands with input  capture input
        
        $class = 'Conso\\Commands\\' . ucfirst($this->input->command[0]); // command

        /**
         * if command exists
         */
        if(class_exists($class)) // bind commands here
        {
            $command = new $class($this->output); // instantiate command
            $command->capture($this->input->options, $this->input->flags); // capture input options and flags

            if((@$this->input->options[0] == "-h") || (@$this->input->flags[0] == "--help")) // display help message of the controller
            {
                $this->output->helpMessage($command->help());
            }

            $command->execute($this->input->command[1] ?? ""); // execute sub command
            exit(1);

        }else{ // no command exists

            if(\in_array($this->input->command[0], $this->input->standardCommands))
            {
                $class   = 'Conso\\Commands\\Help';
                $command = new $class($this->output); // instantiate command
                $command->capture($this->input->options, $this->input->flags); // capture input options and flags
                $command->execute($this->input->command ?? ""); // execute commands
                exit(1);
            }
        }

        throw new CommandNotFoundException('Command ' . $this->input->command[0] . ' not Found ');
    }

    public function run()  // run the application
    {
        try{
            
            $this->bind();
            // execute all command here
            // load all commands from // command
        }catch(\Exception $e)
        {
            $this->output->error("[".get_class($e) . "] \n " . $e->getMessage());
        }
    }

}