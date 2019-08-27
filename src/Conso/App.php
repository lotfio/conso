<?php

namespace Conso;

/*
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
    use CommandTrait;
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
        $this->input   = $input;
        $this->output  = $output;
    }

    /**
     * command bind method.
     */
    public function bind() // bind the imput with the exact command and pass options and flags
    {
 
        $class = $this->input->commands(0) ? ucfirst($this->input->commands(0)) : null;
        $availCommands = $this->readCommands();
        
        if(array_key_exists($class, $availCommands)) // if command exists
        {
            $command = $availCommands[$class] . $class;
            $this->command($command, $this->input->commands(1) ?? null);
            exit(0);
        }

        if (empty($class) || in_array($class, $this->input->defaultFlags())) {
            $class = 'Conso\\Commands\\'.Config::get('DEFAULT_COMMAND');
            $this->command($class, $this->input->commands);
            exit(0);
        }

        throw new CommandNotFoundException('Command '.$this->input->commands(0).' not Found ');
    }

    /**
     * command method.
     *
     * @param string $command
     *
     * @return void
     */
    public function command($command, $subCommand)
    {
        if (!class_exists($command)) 
            throw new CommandNotFoundException('Command '.$this->input->commands(0).' not Found ');
        
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
