<?php namespace Conso;

/**
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
                    case '--help':
                    case '-h':
                        if (method_exists(static::class, 'help')) {
                            die($this->output->writeLn(static::help()));
                        }
                        break;

                    case '--version':
                    case '-v':
                            self::version();
                            exit(1);
                        break;
                    case '--quiet':
                    case '-q':
                         die;
                         
                    default: $this->flags[] = $this->input->flags(0); // default available flags will be added to each class utomatically
                        break;
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
        foreach (glob(COMMANDS.'*.php') as $commandFile) { // get all commands from Commands Dir
            $class = explode('/', str_replace('.php', null, $commandFile));
            $class = $class[count($class) - 1];

            $command = 'Conso\\Commands\\'.ucfirst($class);

            if (class_exists($command)) {
                $comm = new \ReflectionClass($command);

                $comm->hasMethod('description')  // if has description
                ? $this->availableCommands[strtolower($class)] = $command::description() // call
                : $this->availableCommands[strtolower($class)] = ''; // else
            }
        }

        return $this->availableCommands;
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
            ++$i;
        }
        $this->output->writeLn("\n");
    }

    /**
     * get command line white space lenghth
     * this method helps to display commands
     * in a table way like.
     *
     * @param int $key
     */
    public function commandWhiteSpaceLength($key)
    {
        $keys = array_map('strlen', array_keys($this->availableCommands));
        $max  = max($keys);
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
        $this->output->writeLn("\n".APP_NAME, 'yellow');
        $this->output->writeLn(' version '.APP_VERSION);
        $this->output->writeLn(' '.APP_RELEASE_DATE."\n\n", 'green');
    }
}