<?php namespace Conso\Contracts;

/**
 * 
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

interface InputInterface
{
    /**
     * input commands
     *
     * @param integer $index
     * @return void
     */
    public function commands(int $index);

    /**
     * input options
     *
     * @param integer $index
     * @return void
     */
    public function options(int $index);

    /**
     * input flags
     *
     * @param integer $index
     * @return void
     */
    public function flags(int $index);
}