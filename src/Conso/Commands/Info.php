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

class Info extends Command
{

    public function capture($options, $flags) // play around with your captured inputs here
    {
        $this->options = $options;
        $this->flags   = $flags;
    }

    public function execute($action) // execute your actions here and pass your flags
    {
        $this->output->writeLn('Hello World => ' . $action . "\n");
        $this->output->writeLn('Hello World => ' . $action);
        print_r($this->options);
        print_r($this->flags);
    }
}