<?php

namespace  Conso\Contracts;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   2.0.0
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
