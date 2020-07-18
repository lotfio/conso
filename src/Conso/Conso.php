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

/**
 * This class is responsible for linking all components
 * of conso
 */
class Conso
{
    /**
     * additional config methods
     */
    use ConsoTrait;

    /**
     * commands table object
     *
     * @var CommandsTable
     */
    protected $table;

    /**
     * commands linker object
     *
     * @var CommandsTable
     */
    protected $linker;

    /**
     * commands invoker object
     *
     * @var CommandInvoker
     */
    protected $invoker;

    /**
     * active command
     *
     * @var ?array
     */
    public $activeCommand = NULL;

    /**
     * constructor
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->output   = $output;
        $this->table    = new CommandsTable;
        $this->linker   = new CommandLinker($input, $output);
        $this->invoker  = new CommandInvoker($input, $output, $this);
    }

    /**
     * add command method
     *
     * @param  string $name
     * @param  mixed $action
     *
     * @return CommandsTable
     */
    public function command(string $name, $action) : CommandsTable
    {
        return $this->table->add($name, $action);
    }

    /**
     * run application method
     *
     * @param  integer $env
     * @return mixed
     */
    public function run(int $env = 0)
    {
        try{

            $commands = &$this->table->getCommands();

            // pass table defined commands & match
            $this->activeCommand   = $this->linker->link($commands);

            if(!$this->activeCommand)
                return $this->invoker->invokeInformation($commands);

            return $this->invoker->invoke($this->activeCommand);

        }catch(\Exception $e)
        {
            if($this->output->isTestMode()) // is test mode
                throw new \Exception($e);

            $this->output->exception($e, $env);
        }
    }
}