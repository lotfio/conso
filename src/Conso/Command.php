<?php

namespace Conso;

/*
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\FlagNotFoundException;

class Command
{
    /**
     * inout.
     *
     * @var object
     */
    protected $input;

    /**
     * output.
     *
     * @var object
     */
    protected $output;

    protected $description;
    /**
     * available commands.
     *
     * @var array
     */
    public $availableCommands = [];

    /**
     * inject the nedded objects to this base command class
     * so we can use them later on the commands.
     *
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;

        $this->listCommands(); // list defined commands
        $this->defaultFlags(); // trigger default commands
        $this->checkFlags();  // defined command flags
    }

    /**
     * bstandard commands method.
     */
    public function defaultFlags()
    {
        if (!empty($this->input->flags())) { // if there is flags
            if (in_array($this->input->flags(0), $this->input->defaultFlags())) { // execute default commands here

                switch ($this->input->flags(0)) {
                    case '--help': case '-h': die($this->help()); break;
                    case '--version': case '-v': die($this->version()); break;
                    case '--quiet': case '-q': die;

                    default: $this->flags[] = $this->input->flags(0); break;
                    // default available flags will be added to each class automatically
                }
            }
        }
    }

    /**
     * check defined flags.
     *
     * @param array $flags
     */
    public function checkFlags($flg = [])
    {
        $flags = isset($this->flags) ? $this->flags : $flg; // if subclass flags are set otherwise empty for testing

        if (!empty($this->input->flags())) {
            if (!\in_array($this->input->flags(0), $flags)) {
                throw new FlagNotFoundException('Flag '.$this->input->flags(0).' not found !');
            }
        }
    }

    /**
     * list all commands with there description.
     *
     * TODO
     * This method needs to be checkd since we are directly calling
     * static in a none static method
     */
    public function listCommands()
    {
        $commands = preg_grep('/.php$/', scandir(Config::get('DEFAULT_COMMANDS')));
        $commands2 = preg_grep('/.php$/', scandir(Config::get('COMMANDS')));

        $commands = array_merge($commands, $commands2);

        foreach ($commands as $commandFile) { // get all commands from Commands Dir

            $class = explode(DIRECTORY_SEPARATOR, str_replace('.php', null, $commandFile));
            $class = $class[count($class) - 1];

            $baseCommands = Config::get('DEFAULT_COMMANDS_NAMESPACE').ucfirst($class);
            $commands = Config::get('COMMANDS_NAMESPACE').ucfirst($class);

            if (class_exists($baseCommands)) { // default commands
                $this->readCommandDescription($baseCommands, $class);
            }

            if (class_exists($commands)) { // defined commands
                $this->readCommandDescription($commands, $class);
            }
        }

        return $this->availableCommands;
    }

    /**
     * readCommandDescription.
     *
     * @param string $command
     *
     * @return void
     */
    public function readCommandDescription($command, $class)
    {
        $comm = (new \ReflectionClass($command));

        if ($comm->hasProperty('description')) {
            $reflectionProperty = $comm->getProperty('description');
            $reflectionProperty->setAccessible(true);
            $des = $reflectionProperty->getValue($comm->newInstanceWithoutConstructor());
            $this->availableCommands[strtolower($class)] = $des;
        }
    }

    /**
     * display available commands.
     */
    public function displayAvailableCommands()
    {
        $i = 0;
        $this->output->writeLn("Available commands :\n\n", 'yellow');
        foreach ($this->availableCommands as $command => $description) {
            $this->output->writeLn("  $command", 'green');
            $this->output->whiteSpace($this->commandWhiteSpaceLength($i));
            $this->output->writeLn("$description\n");
            $i++;
        }
        $this->output->writeLn("\n");
    }

    /**
     * get command line white space length
     * this method helps to display commands
     * in a table way like.
     *
     * @param int $key
     */
    public function commandWhiteSpaceLength($key)
    {
        $keys = array_map('strlen', array_keys($this->availableCommands));
        $max = max($keys);
        $keys = array_map(function ($elem) use ($max) {
            return $max - $elem + 5; // + desired number of white spaces
        }, $keys);

        return $keys[$key];
    }

    /**
     * display application version.
     */
    public function version()
    {
        $this->output->writeLn("\n".Config::get('APP_NAME'), 'yellow');
        $this->output->writeLn(' version '.Config::get('APP_VERSION'));
        $this->output->writeLn(' '.Config::get('APP_RELEASE_DATE')."\n\n", 'green');
    }
}
