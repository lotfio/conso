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

        if(class_exists($class)) // bind commands here
        {
            $command = new $class($this->output); // instantiate command
            $command->capture($this->input->options, $this->input->flags); // capture input options and flags
            $command->execute($this->input->command[1] ?? ""); // execute command
            exit(1);
        }

        if(empty($this->input->command[0])) // no commands run default command
        {
            $class = 'Conso\\Commands\\Conso';
            $command = new $class($this->output); // instantiate command
            $command->capture($this->input->options, $this->input->flags); // capture input options and flags
            $command->execute($this->input->command[1] ?? ""); // execute command
            exit(1);
        }

        $this->output->error('Error: Command ' . $this->input->command[0] . ' Was not Found ');
    }

    public function run()  // run the application
    {
        $this->bind();
        // execute all command here
        // load all commands from // command
    }

}