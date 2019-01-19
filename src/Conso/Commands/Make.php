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

class Make extends Command
{
    public function execute($sub)
    {
        echo $sub;
    }
 







    public function help(){return "This command help you to create files and store them to spesific location";}
    public function description(){return "Make command help you to create files and store them to spesific location";}
}