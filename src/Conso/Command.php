<?php

namespace Conso;

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

/**
 * This class is base command class.
 */
class Command
{
    /**
     * app instance.
     *
     * @var obj
     */
    protected $app;

    /**
     * base constructor.
     *
     * @param Conso $app
     */
    public function __construct(Conso $app)
    {
        $this->app = $app;
    }
}
