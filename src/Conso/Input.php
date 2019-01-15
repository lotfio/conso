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

    public $command;

    public $option;

    public $flags;

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

        // command + method
        @$this->command = explode(':', $commands[0]);  
        unset($commands[0]);

        //
        $this->options = array_values(array_filter($commands, function($elem){
            return \preg_match("/^\-{0,1}+[a-z]+/", $elem);
        }));

        $this->flags = array_values(array_filter($commands, function($elem){
            return \preg_match("/^\--[a-z]+/", $elem);
        }));
    }
}