<?php

namespace Conso\Contracts;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   0.2.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */
interface InputInterface
{
    /**
     * input commands.
     *
     * @param int $index
     */
    public function commands(int $index);

    /**
     * input options.
     *
     * @param int $index
     */
    public function options(int $index);

    /**
     * input flags.
     *
     * @param int $index
     */
    public function flags(int $index);
}
