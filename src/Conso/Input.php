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

class Input implements InputInterface
{

    /**
     * input command
     *
     * @var string
     */
    public $commands;

    /**
     * input options
     *
     * @var array
     */
    public $options;

    /**
     * input flags
     *
     * @var array
     */
    public $flags;

    /**
     * default  flags
     *
     * @var array
     */
    public $defaultFlags = [
        "-h","--help",
        "-v","--version",
        "-q","--quiet",
        "--ansi","--no-ansi",
        "-n", "--no-interaction",
        "--profile",
        "--no-plugins",
    ];

    /**
     * trigger capture method
     */
    public function __construct()
    {
        $this->capture(); // capture input
    }


    /**
     * input capture method
     *
     * @return void
     */
    public function capture()
    {
        // unsetting arg0 
        $commands = $_SERVER['argv']; unset($commands[0]); // remove file.php
        
        // sort commands
        $commands = array_values($commands);

        if(isset($commands[0]) && !preg_match("/^\-{1,2}[a-z]+/", $commands[0])) // if command is set and not flag
        {
            if(strstr($commands[0], ":")) // if sub command 
            {
                $this->commands = explode(':', $commands[0]);
                unset($commands[0]);
            }else{
    
                $this->commands[] = $commands[0];
                unset($commands[0]);
            }
        }else{ // if not isset command 0

            $this->commands = [];
        }
        
        // input options 
        $this->options = array_values(array_filter($commands, function($elem){
            return !preg_match("/^\-{1,2}[a-z]+/", $elem);
        }));
        

        // input flags
        $this->flags = array_values(array_filter($commands, function($elem){
            return \preg_match("/^\-{1,2}[a-z]+/", $elem);
        }));
    }

    /**
     * input command method
     *
     * @param  int $index
     * @return void
     */
    public function commands(int $index)
    {
        return $this->commands[$index] ?? FALSE; 
    }

    /**
     * input options method
     *
     * @param  int $index
     * @return void
     */
    public function options(int $index)
    {
        return $this->options[$index] ?? FALSE;
    }

    /**
     * input flags method
     *
     * @param  int $index
     * @return void
     */
    public function flags(int $index)
    {
        return $this->flags[$index] ?? FALSE;
    }

    /**
     * default input flags method
     *
     * @param  int $index
     * @return void
     */
    public function defaultFlags(int $index)
    {
        return $this->defaultFlags[$index] ?? FALSE;
    }
}