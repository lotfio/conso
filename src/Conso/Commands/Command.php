<?php

namespace Conso\Commands;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.6.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Command as BaseCommand;
use function Conso\commandHelp;
use Conso\Contracts\CommandInterface;
use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\InputException;

class Command extends BaseCommand implements CommandInterface
{
    /**
     * sub commands.
     *
     * @var array
     */
    protected $sub = [
        'make', 'delete',
    ];

    /**
     * command description.
     *
     * @var string
     */
    protected $description = 'This command helps you to create conso commands.';

    /**
     * command help.
     *
     * @var string
     */
    protected $help = [
        'sub commands' => [
            'make'     => 'make a new conso command.',
            'delete'   => 'delete an existing conso command.',
        ],
        'options'      => [
            'name'     => 'command name to be created or deleted.',
        ]
    ];

    /**
     * execute method.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        commandHelp($this->app->invokedCommand, $output);
    }

    /**
     * make command method.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function make(InputInterface $input, OutputInterface $output): void
    {
        $name = $input->option(0);

        if (!$name) {
            throw new InputException('command name is required.');
        }
        $command = $this->app->getCommandsPath().'/'.ucfirst($name).'.php';

        if (file_exists($command)) {
            throw new InputException("command [$name] already exists.");
        }
        if (!is_writable($this->app->getCommandsPath())) {
            throw new \Exception("no permissions to create a command at this location {$this->app->getCommandsPath()}.");
        }
        $content = file_get_contents(__DIR__.'/stubs/command');
        $content = str_replace('#command#', ucfirst($name), $content);
        $content = str_replace('#namespace#', $this->app->getCommandsNamespace(), $content);

        $create = file_put_contents($command, $content);

        if ($create) {
            $output->success("Command [$name] created successfully.");
        }
        exit;
    }

    /**
     * delete command method.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function delete(InputInterface $input, OutputInterface $output): void
    {
        $name = $input->option(0);

        if (!$name) {
            throw new InputException('command name is required.');
        }
        $command = $this->app->getCommandsPath().'/'.ucfirst($name).'.php';

        if (!file_exists($command)) {
            throw new InputException("command [$name] does not exists.");
        }
        if (!is_writable($this->app->getCommandsPath())) {
            throw new \Exception("no permissions to delete ($name) command");
        }
        if (unlink($command)) {
            $output->success("command [$name] deleted successfully.");
        }
    }
}
