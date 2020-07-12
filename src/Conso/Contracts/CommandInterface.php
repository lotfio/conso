<?php namespace  Conso\Contracts;

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   1.0.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Conso;

interface CommandInterface
{
    /**
     * execute command method
     * this is main command method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @param  Conso           $app
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output, Conso $app) : void;
}