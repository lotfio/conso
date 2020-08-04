<?php

namespace  Conso\Contracts;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.9.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */
interface OutputInterface
{
    /**
     * write line method.
     *
     * @param string $line
     * @param string $color
     * @param string $bg
     * @param int    $bold
     */
    public function writeLn(string $line, string $color, string $bg, int $bold);
}
