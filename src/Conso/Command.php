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

use Conso\Contracts\OutputInterface;
use Conso\Contracts\CommandInterface;

class Command implements CommandInterface
{
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }
}