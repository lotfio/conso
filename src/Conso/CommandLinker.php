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

use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\InputException;

/**
 * This class is responsible of linking input command with
 * defined commands in commands table.
 */
class CommandLinker
{
    /**
     * input object.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * output object.
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * constructor.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * match.
     *
     * @param array $commands
     *
     * @return array
     */
    public function link(array &$commands): ?array
    {
        $command = $this->input->command();
        $subCommand = $this->input->subCommand();
        $flags = $this->input->flags();

        // if command is a class
        for ($i = 0; $i < count($commands); $i++) {
            readCommandPropertiesFromClass($commands[$i]);
        } // fill array info

        if ($command) { // if command
            for ($i = 0; $i < count($commands); $i++) {
                if ($command == $commands[$i]['name'] || in_array($command, $commands[$i]['aliases'])) {
                    if ($subCommand && !in_array($subCommand, $commands[$i]['sub'])) {// match  sub commands

                        throw new InputException("sub command ({$subCommand}) is not defined.");
                    }
                    if (count($flags)) { // match flags
                        foreach ($flags as $flag) {
                            if (!in_array($flag, array_merge($commands[$i]['flags'], $this->input->reservedFlags()))) { // allow only defined and reserved flags

                                throw new InputException("flag ({$flag}) is not defined.");
                            }
                        }
                    }

                    return $commands[$i];
                }
            }

            throw new InputException("command ({$command}) is not defined.");
        }

        if (!$command) {
            if (count($flags)) { // no command link flags
                foreach ($flags as $flag) {
                    if (!in_array($flag, $this->input->reservedFlags())) {
                        throw new InputException("flag ({$flag}) is not defined.");
                    }
                }
            }
        }

        return null;
    }
}
