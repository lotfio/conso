<?php  namespace Conso;

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   1.0.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Contracts\InputInterface;
use Conso\Contracts\OutputInterface;
use Conso\Exceptions\InvokerException;

/**
 * This class is responsible of invoking commands
 * invoke callback or controller method
 */
class CommandInvoker
{
    /**
     * conso app instance
     *
     * @var Cons
     */
    protected $app;

    /**
     * input object
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * output object
     *
     * @var OutputInterface
     */
    protected $output;

    /**
     * constructor
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output, Conso $app)
    {
        $this->input  = $input;
        $this->output = $output;
        $this->app    = $app;
    }

    /**
     * invoke application information method
     *
     * @param array $commands
     * @return void
     */
    public function invokeInformation(array $commands)
    {
        $this->output->writeLn($this->app->getSignature() . "\n");
        $this->output->writeLn($this->app->getName() . " ", "yellow");
        $this->output->writeLn("version ");
        $this->output->writeLn($this->app->getVersion(), 'green');
        $this->output->writeLn(" by " . $this->app->getAuthor());

        $this->output->writeLn("\n\nUsage: \n\n", 'yellow');
        $this->output->writeLn("    command:subcommand [options] [-flags]\n\n");

        $this->output->writeLn("Special flags: \n\n", 'yellow');

        $flags = $this->input->reservedFlags();
        $this->output->writeLn("    " . $flags[0] . "   ",   'green');
        $this->output->writeLn("    " . $flags[1] . "   \n", 'green');
        $this->output->writeLn("    " . $flags[2] . "   ",   'green');
        $this->output->writeLn("    " . $flags[3] . "   \n", 'green');
        $this->output->writeLn("    " . $flags[4] . "   ",   'green');
        $this->output->writeLn("    " . $flags[5] . "   \n", 'green');
        $this->output->writeLn("    " . $flags[6] . "   ",   'green');
        $this->output->writeLn("    " . $flags[7] . "   \n", 'green');
        $this->output->writeLn("    " . $flags[8] . "   ",   'green');
        $this->output->writeLn(         $flags[9] . "   \n", 'green');
        $this->output->writeLn("    " . $flags[10] . "   ",   'green');
        $this->output->writeLn("    " . $flags[11] . "   \n", 'green');

        // remove special commands
        $commands = array_filter($commands, function($elem){
            if(strpos($elem['name'], '--') === FALSE) return $elem;
        });

        if(count($commands) > 0)
        {
            $this->output->writeLn("\nAvailable Commands: \n\n", 'yellow');

            $max = max(array_map(function($elem){ return count($elem);}, $commands));

            foreach($commands as $command)
            {
                $this->output->writeLn("  ". $command['name'] .  str_repeat(' ', ($max - strlen($command['name'])) + 4 ), 'green');
                $this->output->writeLn($command['description'] .  "\n");
            }
            $this->output->writeLn("\n");
        }
    }

    /**
     * invoke method
     *
     * @param  array $command
     * @return void
     */
    public function invoke(array $command)
    {
        // invoke callback
        if(is_callable($command['action']))
            return $this->invokeCallback($command);

        // invoke class method or (execute)
        return $this->invokeClassMethod($command);
    }

    /**
     * invoke callback method
     *
     * @param  array $command
     * @return void
     */
    protected function invokeCallback(array $command)
    {
        return call_user_func_array($command['action'], array($this->input, $this->output, $this->app));
    }

    /**
     * Undocumented function
     *
     * @param array $command
     * @return void
     */
    protected function invokeClassMethod(array $command)
    {
        $subCommand = $this->input->subCommand();
        $class      = ucfirst($command['action']);

        if(!class_exists($class))
            throw new InvokerException("command class ($class) is not defined.");

        $method = ($subCommand !== NULL) ? $subCommand : 'execute';

        $obj    = new $class($this->input, $this->output, $this->app);

        if(!method_exists($obj, $method))
            throw new InvokerException("command method ($method) is not defined.");

        return call_user_func_array(array($obj, $method), array($this->input, $this->output, $this->app));
    }
}