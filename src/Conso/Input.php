<?php namespace Conso;

use Conso\Contracts\InputInterface;

/**
 * 
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

class Input implements InputInterface
{

    /**
     * input command
     *
     * @var string
     */
    public $commands;

    /**
     * default options and flags
     *
     * @var array
     */
    public $standardCommands = [
        "-h","--help",
        "-v","--version",
        "-q","--quiet",
        "--ansi","--no-ansi",
        "-n", "--no-interaction",
        "--profile",
        "--no-plugins",
    ];

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
        $commands = $_SERVER['argv'];unset($commands[0]);
        
        // sort commands
        $commands = array_values($commands);

        if(isset($commands[0]) && !preg_match("/^\-/", $commands[0]))
        {
            $this->commands = explode(':', $commands[0]);
        }
        

        //options
        $this->options = array_values(array_filter($commands, function($elem){
            return \preg_match("/^\-{0,1}+[a-z]+$/", $elem);
        }));

        if(isset($this->commands[0])) // remove command from option
        {
            unset($this->options[0]);
            $this->options = array_values($this->options);
        }

        // flags
        $this->flags = array_values(array_filter($commands, function($elem){
            return \preg_match("/^\--[a-z]+/", $elem);
        }));
    }
}