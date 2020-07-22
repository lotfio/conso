<?php

namespace Conso;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.5.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

/**
 * This class is responsible for defining and
 * configuring commands.
 */
class CommandsTable
{
    /**
     * commands array.
     *
     * @var array
     */
    private $commands = [

    ];

    /**
     * add command method.
     *
     * @param string $name
     * @param mixed  $action
     *
     * @return self
     */
    public function add(string $name, $action): self
    {
        $this->commands[] = [
            'name'          => $name,
            'aliases'       => [],
            'sub'           => [],
            'action'        => $action,
            'flags'         => [],
            'description'   => '',
            'help'          => [],
        ];

        return $this;
    }

    /**
     * edit command elements.
     *
     * @param string $key
     *
     * @return void
     */
    protected function assign(string $key, $value)
    {
        $this->commands[count($this->commands) - 1][$key] = $value;
    }

    /**
     * sub commands method.
     *
     * @param string|array ...$aliases
     *
     * @return self
     */
    public function sub(...$sub): self
    {
        $this->assign('sub', flatten($sub));

        return $this;
    }

    /**
     * aliases method.
     *
     * @param string|array ...$aliases
     *
     * @return self
     */
    public function alias(...$aliases): self
    {
        $this->assign('aliases', flatten($aliases));

        return $this;
    }

    /**
     * flags method.
     *
     * @param string|array ...$flags
     *
     * @return self
     */
    public function flags(...$flags): self
    {
        $this->assign('flags', flatten($flags));

        return $this;
    }

    /**
     * description method.
     *
     * @return void
     */
    public function description(string $desc): self
    {
        $this->assign('description', $desc);

        return $this;
    }

    /**
     * help message method.
     *
     * @return void
     */
    public function help(array $help): self
    {
        $this->assign('help', $help);

        return $this;
    }

    /**
     * get commands method.
     *
     * @return void
     */
    public function &getCommands(): array
    {
        return $this->commands;
    }
}
