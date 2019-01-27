<?php namespace Conso\Commands;

/**
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command;
use Conso\Contracts\CommandInterface;

class Example extends Command implements CommandInterface
{
    protected $flags = [];

    public function execute($sub, $options, $flags)
    {
    }

    




    public function help()
    {
        return 'This is example command that helps you create other commands';
    }

    public function description()
    {
        return 'Example conso command';
    }
}
