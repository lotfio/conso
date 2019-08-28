<?php

namespace Conso\Commands;

/*
* @author    <contact@lotfio.net>
* @package   Conso PHP Console Creator
* @version   0.1.0
* @license   MIT
* @category  CLI
* @copyright 2019 Lotfio Lakehal
*/

use Conso\Config;
use Conso\CommandTrait;
use Conso\Command as BaseCommand;
use Conso\Contracts\CommandInterface;
use Conso\Exceptions\OptionNotFoundException;
use Conso\Exceptions\RunTimeException;

class Command extends BaseCommand implements CommandInterface
{
    /**
     * command flags.
    *
    * @var array
    */
    protected $flags = [];

    /**
     * Command description.
    *
    * @var string
    */
    protected $description = 'Example conso command.';

    /**
     * command execute method.
    *
    * @param string $sub
    * @param array  $options
    * @param array  $flags
    *
    * @return void
    */
    public function execute($sub, $options, $flags)
    {
        if (!empty($sub)) {
            switch ($sub) {

            case 'make': die($this->makeNewCommand($options)); break;
            case 'delete': die($this->deleteCommand($options)); break;

            default: throw new RunTimeException('Error sub command not recognized ! '); break;
        }
        }

        $this->help();
    }

    /**
     * make new command method.
    *
    * @param string $options
    *
    * @return void
    */
    public function makeNewCommand($options)
    {
        if (!isset($options[0]) || empty($options[0])) {
            throw new OptionNotFoundException('Command name is required ! ');
        }

        $name = ucfirst(strtolower($options[0]));
        $stubFile = Config::get('DEFAULT_COMMANDS').'Helpers'.DIRECTORY_SEPARATOR.'Stubs'.DIRECTORY_SEPARATOR.'Command.stub';

        if (!file_exists($stubFile)) {
            throw new RunTimeException("Error file $stubFile not found");
        }

        if (array_key_exists($name, $this->readCommands())) {
            throw new RunTimeException("Error command $name already exists !");
        }

        $stub = file_get_contents($stubFile);

        if(!is_string(Config::get('NAMESPACE')))
        {
            $namespace = array_values($this->readCommands());
            $namespace = trim($namespace[count($namespace) -1], "\\");
        }else{
            $namespace = trim(Config::get('NAMESPACE'), "\\");
        }

        $stub = str_replace('#namespace#', $namespace, $stub);
        $stub = str_replace('#command#', $name, $stub);
        $stub = str_replace('#time#', date('d-m-Y'), $stub);

        $arr  = Config::get('COMMANDS');
        $file = trim($arr[count($arr) - 1], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name . '.php';

        $commandHundle = fopen($file, 'w+');

        if (fwrite($commandHundle, $stub)) {
            $this->output->writeLn("\nGenerating command file : \n\n", 'green');
            $this->output->timer();
            $this->output->writeLn("\n\n");
            exit(0);
        }

        throw new RunTimeException('Error making command !');
    }

    /**
     * delete command method.
    *
    * @param array $options
    *
    * @return void
    */
    public function deleteCommand($options)
    {
        if (!isset($options[0]) || empty($options[0])) {
            throw new OptionNotFoundException('Command name is required ! ');
        }

        $name = ucfirst($options[0]);
        $arr  = Config::get('COMMANDS');
        $file = trim($arr[count($arr) - 1], DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $name . '.php';


        if (!file_exists($file)) {
            throw new RunTimeException("Error command $name not found !");
        }
        $this->output->writeLn("\n");
        $this->output->writeLn("Are you sure you want to delete $name command ? [Y/N] : ");
        $ask = readline('');

        if (strtolower($ask) == 'y' or strtolower($ask) == 'yes') {
            unlink($file);

            $this->output->writeLn("\n");
            $this->output->timer();
            $this->output->writeLn("\n\nCommand $name has been deleted successfully.", 'green');
            $this->output->writeLn("\n\n");
            exit(1);
        }

        $this->output->writeLn("\n Abroting : command $name not deleted \n\n", 'yellow');
    }

    /**
     * command description method.
    *
    * @return string
    */
    public function help()
    {
        $this->output->writeLn("\n [ command ] \n\n", 'yellow');
        $this->output->writeLn("   example command helps you to create commands for your console application.\n\n");
        $this->output->writeLn("  sub commands : \n\n", 'yellow');
        $this->output->writeLn("    make    : make a new command.\n");
        $this->output->writeLn("    delete  : delete an existing command.\n\n");
        $this->output->writeLn("  options : \n\n", 'yellow');
        $this->output->writeLn("    command name (to be created or deleted).\n\n");

        return '';
    }
}
