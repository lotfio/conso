<?php

namespace Conso;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.7.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Contracts\InputInterface;

/**
 * This class is responsible for handling user input
 * either from cli argv or custom argv (handy if we want to invoke cli from http).
 */
class Input implements InputInterface
{
    /**
     * Input command.
     *
     * @var ?string
     */
    private $command = null;

    /**
     * Input sub command.
     *
     * @var ?string
     */
    private $subCommand = null;

    /**
     * Input options.
     *
     * @var array
     */
    private $options = [

    ];

    /**
     * Input flags.
     *
     * @var array
     */
    private $flags = [

    ];

    /**
     * reserved flags.
     *
     * @var array
     */
    private $reservedFlags = [
        '-h',       '--help',
        '-v',       '--version',
        '-c',       '--commands',
        '-q',       '--quiet',
        '--ansi',   '--no-ansi',
        '-n',       '--no-interaction',
    ];

    /**
     * executable file.
     *
     * @var string
     */
    private $executable;

    /**
     * constructor
     * set up argv or user argv.
     *
     * @param ?string $arguments
     */
    public function __construct(?string $userArgv = null)
    {
        // get argv and remove file name
        global $argv;
        $this->executable = $argv[0] ?? null;
        unset($argv[0]);

        // get argv or user argv
        $argv = (is_string($userArgv) && strlen($userArgv) > 0)
              ? array_values(array_filter(explode(' ', $userArgv)))
              : array_values($argv);

        $this->extract($argv);
    }

    /**
     * extract argv array to commands, sub commands, options & flags.
     *
     * @return void
     */
    private function extract(array $argv): void
    {
        // set command if no sub command
        if (isset($argv[0]) && !preg_match('/^[\-]{1,2}[A-z]+((\-\w+)|(\=.*))?$/', $argv[0])) {
            $this->command = $argv[0] ?? null;

            // if command & sub command
            if (preg_match('/^([A-z]+)(\:)([A-z]+)$/', $argv[0])) {
                $command = explode(':', $argv[0]);
                $this->command    = $command[0] ?? null;
                $this->subCommand = $command[1] ?? null;
            }

            // reset argv array
            unset($argv[0]);
        }

        $flags         = $this->captureFlags($argv);

        $this->flags   = $this->extractFlags($flags);

        $this->options = array_values(array_diff($argv, $flags));
    }

    /**
     * extract flags method
     *
     * @param array $argv
     * @return array
     */
    private function captureFlags(array $argv) : array
    {
        $flags = array_filter($argv, function ($elem) {
            return preg_match('/^[\-]{1,2}[A-z]+((\-\w+)|(\=.*))?$/', $elem);
        });

        return $flags;
    }

    /**
     * extract flags
     *
     * @param  array $flags
     * @return array
     */
    private function extractFlags(array $flags) : array
    {
        $flagsWithValues = [];

        foreach($flags as $flag)
        {
            if(strpos($flag, '=') !== FALSE)
            {
                $exp = explode('=', $flag);
                $flagsWithValues[$exp[0]] = $exp[1];
                continue;
            }

            $flagsWithValues[$flag] = '';
        }

        return $flagsWithValues;
    }

    /**
     * get command method.
     *
     * @return string|null
     */
    public function command(): ?string
    {
        return $this->command;
    }

    /**
     * get sub command method.
     *
     * @return string|null
     */
    public function subCommand(): ?string
    {
        return $this->subCommand;
    }

    /**
     * input option method.
     *
     * @param int $index
     *
     * @return string|null
     */
    public function option(int $index): ?string
    {
        return isset($this->options[$index]) ? $this->options[$index] : null;
    }

    /**
     * input options method.
     *
     * @return array
     */
    public function options(): array
    {
        return $this->options;
    }

    /**
     * input flag method.
     *
     * @param string $flag
     *
     * @return mixed
     */
    public function flag(string $flag)
    {
        return isset($this->flags[$flag]) ? $this->flags[$flag] : false;
    }

    /**
     * input flags method.
     *
     * @return array
     */
    public function flags(): array
    {
        return array_keys($this->flags);
    }

    /**
     * get executable file.
     *
     * @return void
     */
    public function getExecutable(): string
    {
        return $this->executable;
    }

    /**
     * reserved flags.
     *
     * @return void
     */
    public function reservedFlags()
    {
        return $this->reservedFlags;
    }

    /**
     * read line method
     *
     * @param string $line
     * @return void
     */
    public function readLine(string $line)
    {
        return readLine($line);
    }
}
