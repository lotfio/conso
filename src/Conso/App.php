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
use Conso\Exceptions\FlagNotFoundException;

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

    /**
     * constructor
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
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
        $class = $this->input->commands(0) ? ucfirst($this->input->commands(0)) : NULL;

        if(isset($class) && class_exists('Conso\\Commands\\' . $class))
        {   
            $class   = 'Conso\\Commands\\' . $class; // command
            $command = new $class($this->input, $this->output);
            $command->execute($this->input->commands(1) ?? null, $this->input->options(), $this->input->flags()); // sub command or null
            exit;

        }else{

            if(empty($class) || \in_array($class, $this->input->defaultFlags()))
            {
                $command = 'Conso\\Commands\\' . DEFAULT_COMMAND;
                $command = new $command($this->input, $this->output);
                $command->execute($this->input->commands(), $this->input->options() , $this->input->flags()); // sub command or null
                exit;
            }
        }

        throw new CommandNotFoundException('Command ' . $this->input->commands(0) . ' not Found ');
    }

    /**
     * 
     */
    public function run()  // run the application
    {
        try{
            
            $this->bind();

        }catch(\Exception $e)
        {
            $this->output->error("[".get_class($e) . "] \n " . $e->getMessage());
        }
    }

}