<?php namespace  Conso\Contracts;

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