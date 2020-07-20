<?php

namespace  Conso\Contracts;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.0.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Conso;

interface CommandInterface
{
    /**
     * execute command method
     * this is main command method.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Conso           $app
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output) : void;
}
