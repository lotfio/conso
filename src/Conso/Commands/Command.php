<?php namespace Conso\Commands;

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   1.0.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Conso;
use Conso\Command as BaseCommand;
use Conso\Exceptions\InputException;
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Command extends BaseCommand implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub = array(
        'make','delete'
    );

    /**
     * command description
     *
     * @var string
     */
    protected $description = 'This command helps you to create conso commands.';

    /**
     * command help
     *
     * @var string
     */
    protected $help    = array(
        "sub commands" => array(
            "make"     => "make a new conso command.",
            "delete"   => "delete conso command."
        ),
        "options"      => array(
            "name"     => "command name"
        )
    );

    /**
     * execute method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output) : void
    {
        $this->displayCommandHelp($input, $output);
    }

    /**
     * make command method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function make(InputInterface $input, OutputInterface $output) : void
    {
        $name = $input->option(0);

        if(!$name)
            throw new InputException("command name is required.");

        $command =  $app->getCommandsPath() . '/' . ucfirst($name) . '.php';

        if(file_exists($command))
            throw new InputException("command [$name] already exists.");

        if(!is_writable($app->getCommandsPath()))
            throw new \Exception("no permissions to create a command at this location {$app->getCommandsPath()}.");

        $content = file_get_contents(__DIR__ . "/stubs/command");
        $content = str_replace('#command#', ucfirst($name), $content);
        $content = str_replace('#namespace#', $app->getCommandsNamespace(), $content);

        $create = file_put_contents($command, $content);

        if($create)
            $output->success("Command [$name] created successfully.");
        exit;
    }

    /**
     * delete command method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function delete(InputInterface $input, OutputInterface $output) : void
    {
        $name = $input->option(0);

        if(!$name)
            throw new InputException("command name is required.");

        $command =  $app->getCommandsPath() . '/' . ucfirst($name) . '.php';

        if(!file_exists($command))
            throw new InputException("command [$name] does not exists.");

        if(!is_writable($app->getCommandsPath()))
            throw new \Exception("no permissions to delete ($name) command");

        if(unlink($command))
            $output->success("command [$name] deleted successfully.");
    }
}