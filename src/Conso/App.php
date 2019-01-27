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
     * input.
     *
     * @var object
     */
    private $input;

    /**
     * output.
     *
     * @var object
     */
    private $output;

    /**
     * constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;
    }

    /**
     * command bind method.
     */
    public function bind() // bind the imput with the exact command and pass options and flags
    {
        // bind commands with input  capture input
        $class = $this->input->commands(0) ? ucfirst($this->input->commands(0)) : null;

        if (isset($class) && class_exists('Conso\\Commands\\'.$class)) {

            $class = 'Conso\\Commands\\'.$class;

            $this->command($class, $this->input->commands(1) ?? null);
            exit;

        } else {

            if (empty($class) || \in_array($class, $this->input->defaultFlags())) {
                
                $class = "Conso\\Commands\\" . DEFAULT_COMMAND;
                $this->command($class, $this->input->commands);
                exit;
            }
        }

        throw new CommandNotFoundException('Command '.$this->input->commands(0).' not Found ');
    }

    /**
     * command method 
     * 
     * @param  string $command
     * @return void
     */
    public function command($command, $subCommand)
    {
        if(!class_exists($command)) throw new CommandNotFoundException('Command '.$this->input->commands(0).' not Found ');
        $command = new $command($this->input, $this->output);
        return $command->execute($subCommand, $this->input->options, $this->input->flags); // sub command or null
    }

    /**
     * run app method.
     */
    public function run()  // run the application
    {
        try {
            
            $this->bind();
        
        } catch (\Exception $e) {
            die($this->output->error('['.get_class($e)."] \n ".$e->getMessage()));
        }
    }
}