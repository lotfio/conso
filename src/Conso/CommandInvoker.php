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
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\InvokerException;

/**
 * This class is responsible of invoking commands
 * invoke callback or controller method.
 */
class CommandInvoker
{
    /**
     * conso app instance.
     *
     * @var Cons
     */
    protected $app;

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
    public function __construct(InputInterface $input, OutputInterface $output, Conso $app)
    {
        $this->input = $input;
        $this->output = $output;
        $this->app = $app;
    }

    /**
     * invoke application information method.
     *
     * @param array $commands
     *
     * @return void
     */
    public function showConsoleInformation(array $commands)
    {
        $output = $this->output;
        $app = $this->app;

        $output->writeLn($app->getSignature()."\n");
        $output->writeLn($app->getName().' ', 'yellow');
        $output->writeLn('version ');
        $output->writeLn($app->getVersion(), 'green');
        $output->writeLn(' by '.$app->getAuthor());

        $output->writeLn("\n\nUsage: \n\n", 'yellow');
        $output->writeLn("  command:subcommand [options] [flags]\n\n");

        $output->writeLn("Special flags: \n\n", 'yellow');

        $flags = $this->input->reservedFlags();

        for ($i = 0; $i < count($flags); $i++) {   // 6 = --ansi length
            $line = '  '.$flags[$i].str_repeat(' ', (6 - strlen($flags[$i])) + 3).$flags[++$i]."\n";
            $output->writeLn($line, 'green');
        }
    }

    /**
     * show console commands.
     *
     * @param array $commands
     *
     * @return void
     */
    public function showConsoleCommands(array $commands) : void
    {
        if (count($commands) < 1) return;

        // sort & get max length command
        sort($commands);
        $max = max(array_map(function ($elem) { return count($elem); }, $commands));

        // group commands
        $grouped = [];

        foreach($commands as $command)
            $grouped[$command['group']][] = $command;

        $this->output->writeLn("\nAvailable Commands:\n\n", 'yellow');

        if(isset($grouped['main'])) //no groups
        {
            foreach($grouped['main'] as $command)
            {
                $this->output->writeLn('  '.$command['name'].str_repeat(' ', ($max - strlen($command['name'])) + 4), 'green');
                $this->output->writeLn($command['description']."\n");
            }

            unset($grouped['main']);
        }

        foreach($grouped as $group => $commands) // if groups
        {
            $this->output->writeLn("\n$group\n\n", 'yellow');

            foreach ($commands as $command) {
                $this->output->writeLn('  '.$command['name'].str_repeat(' ', ($max - strlen($command['name'])) + 4), 'green');
                $this->output->writeLn($command['description']."\n");
            }
        }
    }

    /**
     * invoke method.
     *
     * @param ?array $command
     *
     * @return void
     */
    public function invoke(?array $command)
    {
        $commands = $this->app->getCommands(); // defined commands

        // disable ansi
        if ($this->input->flag('--no-ansi') !== false) {
            $this->output->disableAnsi();
        }

        // command help
        if ($this->input->command() && ($this->input->flag('-h') !== false || $this->input->flag('--help') !== false)) {
            return commandHelp($command, $this->output);
        }

        // version
        if (($this->input->flag('-v') !== false || $this->input->flag('--version') !== false)) {
            return $this->output->writeLn("\n ".$this->app->getName().' version '.$this->app->getVersion()."\n", 'yellow');
        }

        if (($this->input->flag('-c') !== false || $this->input->flag('--commands') !== false)) {
            return $this->showConsoleCommands($commands);
        }

        if (is_null($this->input->command())) { // no command
            $this->showConsoleInformation($commands);
            $this->showConsoleCommands($commands);

            return;
        }

        // invoke callback
        if (is_callable($command['action'])) {
            return $this->invokeCallback($command);
        }

        // invoke class method or (execute)
        return $this->invokeClassMethod($command);
    }

    /**
     * invoke callback method.
     *
     * @param array $command
     *
     * @return void
     */
    protected function invokeCallback(array $command)
    {
        $closure = \Closure::bind($command['action'], $this->app);
        return call_user_func_array($closure, [$this->input, $this->output]);
    }

    /**
     * invoke class method.
     *
     * @param array $command
     *
     * @return void
     */
    protected function invokeClassMethod(array $command)
    {
        $subCommand = $this->input->subCommand();

        // append namespace
        $namespace = (!is_null($command['namespace'])) ? rtrim($command['namespace'], '\\') . '\\' : '';
        $class     =  $namespace . ucfirst($command['action']);

        if (!class_exists($class)) {
            throw new InvokerException("command class ($class) is not defined.");
        }

        $method = ($subCommand !== null) ? $subCommand : 'execute';

        $obj = new $class($this->app);

        if (!method_exists($obj, $method)) {
            throw new InvokerException("command method ($method) is not defined.");
        }

        return call_user_func_array([$obj, $method], [$this->input, $this->output]);
    }
}
