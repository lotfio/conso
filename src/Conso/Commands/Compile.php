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

use Conso\Command;
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
    protected $description = 'Compile your package to a shareable phar file.';

    /**
     * set up command dependencies
     */
    public function __construct()
    {
        $this->cwd = getcwd();
        $this->packageFile = $this->cwd . DIRECTORY_SEPARATOR . 'conso.json';
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

        if(ini_get('phar.readonly') == 1)
            throw new CompileException("phar is read only mode ! it should be turned off from php.init to compile.");

        // read package file
        $rules = (array) json_decode(file_get_contents($this->packageFile));

        // validate package file
        if(!array_key_exists('src', $rules))   throw new CompileException("source (src) directory is missing from package file.");
        if(!array_key_exists('build', $rules)) throw new CompileException("build (build) directory is missing from package file.");
        if(!array_key_exists('stub', $rules))  throw new CompileException("stub (stub) file is missing from package file.");
        if(!array_key_exists('phar', $rules))  throw new CompileException("output (phar) file is missing from package file.");
        
        // create a phar file if everything went well
        $this->createPhar($rules);
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
                "src/Conso",
                "vendor"
            ),
            "build" => "build/",
            "stub"  => "stub",
            "phar"  => "conso.phar"
        );

        if(\file_put_contents($this->packageFile, json_encode($content, JSON_PRETTY_PRINT)))
            exit($output->writeLn("\nbuild file created successfully.\n\n", 'green'));

        $output->writeLn("error creating build file.\n", 'red');
    }

    /**
     * validate build file 
     *
     *  @param string
     * @return void
     */
    private function validateBuildFile(array $file)
    {

    }

    /**
     * create a stub file
     * 
     * @param   string $file
     * @return void
     */
    private function createStubFile(string $file)
    {

    }

        /**
     * create phar archive
     *
     * @return void
     */
    private function createPhar(array $rules)
    {
        deleteTree($rules['build'] . "package");
        copyDirectory($rules['src'][0], $rules['build'] . "package/src/Conso");
        copyDirectory("vendor", $rules['build'] . "package/vendor");

        $stub = file_get_contents("conso");
        $stub = preg_replace("/\#.*\n/", NULL, $stub);
        $stub = preg_replace('/\$conso->run\(\);/', '$conso->disableBuiltInCommands(); $conso->run();', $stub);

        file_put_contents($rules['build'] . "package/conso", $stub);

        // create phar
        $phar = new \Phar($rules['build'] . $rules['phar']);

        // start buffering. Mandatory to modify stub to add shebang
        $phar->startBuffering();

        // Create the default stub from conso entry point
        $defaultStub = $phar->createDefaultStub($rules['stub']);

        // Add the rest of the apps files
        $phar->buildFromDirectory($rules['build'] . "package/");

        // Customize the stub to add the shebang
        $stub = "#!/usr/bin/env php \n" . $defaultStub;

        // Add the stub
        $phar->setStub($stub);

        $phar->stopBuffering();

        // plus - compressing it into gzip  
        $phar->compressFiles(\Phar::GZ);

        # Make the file executable
        chmod($rules['build'] . $rules['phar'], 0770);
        deleteTree($rules['build'] . "package");
    }

}