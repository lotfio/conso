<?php

namespace Conso;

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
        $options = $this->input->options();
        $flags = $this->input->flags();

        // check flags before link
        $this->checkFlagsBeforeLink();

        // if command is a class
        for ($i = 0; $i < count($commands); $i++) {
            readCommandPropertiesFromClass($commands[$i]);
        } // fill array info

        if (!$command) { // if no command only flags
            $this->linkFlags($flags);

            return null;
        }

        for ($i = 0; $i < count($commands); $i++) {
            if ($command == $commands[$i]['name'] || in_array($command, $commands[$i]['aliases'])) {
                $this->linkSubCommand($subCommand, $commands[$i]['sub']);

                $this->linkOptions($options);

                $this->linkFlags($flags, $commands[$i]['flags']);

                return $commands[$i];
            }
        }

        throw new InputException("command ({$command}) is not defined.");
    }

    /**
     * link sub command method.
     *
     * @param string|null $subCommand
     * @param array       $sub
     *
     * @return void
     */
    private function linkSubCommand(?string $subCommand, array $sub): void
    {
        if ($subCommand && !in_array($subCommand, $sub)) {// match  sub commands

            throw new InputException("sub command ({$subCommand}) is not defined.");
        }
    }

    /**
     * link options.
     *
     * @param array $options
     *
     * @return void
     */
    public function linkOptions(array $options)
    {
        foreach ($options as $option) {
            if (!preg_match('/^[A-z0-9]+$/', $option)) {
                throw new InputException('oly alpha-numeric characters are allowed for options ([A-z0-9]+)');
            }
        }
    }

    /**
     * link flags method.
     *
     * @param array $flags
     * @param array $reserved
     *
     * @return void
     */
    private function linkFlags(array $flags, array $reserved = []): void
    {
        if (count($flags)) {
            foreach ($flags as $flag) {
                if (!in_array($flag, array_merge($reserved, $this->input->reservedFlags()))) {
                    throw new InputException("flag ({$flag}) is not defined.");
                }
            }
        }
    }

    /**
     * check flags before link
     *
     * @return void
     */
    private function checkFlagsBeforeLink()
    {
        // disable ansi
        if ($this->input->flag('--no-ansi') !== false) {
            $this->output->disableAnsi();
        }

        if (($this->input->flag('-vv') !== false || $this->input->flag('--verbose') !== false)) {
            $this->output->enableVerbosity();
        }
    }
}
