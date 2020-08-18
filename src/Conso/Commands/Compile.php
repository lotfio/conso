<?php namespace Conso\Commands;

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   1.9.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\{Conso, Command};
use Conso\Exceptions\{CompileException,InputException};
use Conso\Contracts\{CommandInterface,InputInterface,OutputInterface};

class Compile extends Command implements CommandInterface
{
    /**
     * sub commands
     *
     * @var array
     */
    protected $sub = [
        'init'
    ];

    /**
     * flags
     *
     * @var array
     */
    protected $flags = [

    ];

    /**
     * command help
     *
     * @var array
     */
    protected $help  = [

    ];

    /**
     * command description
     *
     * @var string
     */
    protected $description = 'Compile your package to a shareable single phar file.';

    /**
     * set up command dependecies
     */
    public function __construct()
    {
        $this->cwd = getcwd();
        $this->packageFile = $this->cwd . DIRECTORY_SEPARATOR . 'pkg.json';
    }

    /**
     * execute method
     *
     * @param  InputInterface  $input
     * @param  OutputInterface $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output) : void
    {
        if(!\file_exists($this->packageFile))
            throw new CompileException("package file ($this->packageFile) not found");
    }

    /**
     * init package to compile
     *
     * @return void
     */
    public function init(InputInterface $input, OutputInterface $output)
    {
        if(!\is_writable($this->cwd))
            throw new InputException("{$this->cwd} is not writable.");

        if(\file_exists($this->packageFile))
            throw new InputException("build file ({$this->packageFile}) exists already.");

        $content = array(
            "src" => array(
                "src/Conso"
            ),
            "build" => "build/",
            "stub"  => "conso"
        );

        if(\file_put_contents($this->packageFile, json_encode($content, JSON_PRETTY_PRINT)))
            exit($output->writeLn("\nbuild file created successfully.\n\n", 'green'));

        $output->writeLn("error creating build file.\n", 'red');
    }
}