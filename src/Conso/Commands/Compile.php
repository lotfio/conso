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
        $buildFile = (array) json_decode(file_get_contents($this->packageFile));

        // validate build file
        $this->validateBuildFile($buildFile);
        
        // create a phar file if everything went well
       $this->createPhar($buildFile);
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

        $content = [
            "src" => [
                "src/Conso",
                "vendor"
            ],
            "build" => "build/",
            "stub"  => "conso",
            "phar"  => "conso.phar"
        ];

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
        if(!is_array($file) || count($file) < 4)
            throw new CompileException("build file is not a valid json file.");

        if(!in_array('src', array_keys($file)))
            throw new CompileException("source (src) directory is missing from package file.");

        if(!in_array('build', array_keys($file)))
            throw new CompileException("build (build) directory is missing from package file.");

        if(!in_array('stub', array_keys($file)))
            throw new CompileException("stub (stub) file is missing from package file.");

        if(!in_array('phar', array_keys($file)))
            throw new CompileException("output (phar) file is missing from package file.");

        if(!is_array($file['src']))
            throw new CompileException("source (src) directory must be an array of valid directories.");

        foreach($file['src'] as $dir)
            if(!is_dir($dir))
                throw new CompileException("source ($dir) directory is not a valid directory.");
        
        if(!is_string($file['build']) || !is_dir($file['build']) || !is_writable($file['build']))
            throw new CompileException("build ({$file['build']}) directory is not a valid directory.");

        if(!is_string($file['stub']) || !file_exists($file['stub']))
            throw new CompileException("stub file ({$file['stub']}) not found.");

        if(!is_string($file['phar']) || strlen($file['phar']) < 1 || preg_match('/\.phar$/', $file['phar']) == false)
            throw new CompileException("phar file ({$file['phar']}) must be a valid file ends with .phar extension.");
    }

    /**
     * create a stub file
     * 
     * @param   string $file
     * @return void
     */
    private function createStubFile(string $file)
    {
        //$stub = file_get_contents($file);
        //$stub = preg_replace("/\#.*\n/", NULL, $stub);
        //$stub = preg_replace('/\$conso->run\(\);/', '$conso->disableBuiltInCommands(); $conso->run();', $stub);
        //file_put_contents($rules['build'] . "package/conso", $stub);
    }

    /**
     * create phar archive
     *
     * @return void
     */
    private function createPhar(array $rules)
    {
        $buildLocation = rtrim($rules['build'], '/') . "/package/";

        // delete old build files if any
        deleteTree($buildLocation);

        // copy project
        foreach($rules['src'] as $src)
            copyDirectory($src, $buildLocation . rtrim($src, '/'));

        // copy stub file
        copy($rules['stub'], $buildLocation . $rules['stub']);

        // create phar
        $phar = new \Phar(rtrim($rules['build'], '/') . "/" . $rules['phar']);

        // start buffering. Mandatory to modify stub to add shebang
        $phar->startBuffering();

        // Create the default stub from conso entry point
        $defaultStub = $phar->createDefaultStub($rules['stub']);

        // Add the rest of the apps files
        $phar->buildFromDirectory($buildLocation);

        // Customize the stub to add the shebang
        $stub = "#!/usr/bin/env php \n" . $defaultStub;

        // Add the stub
        $phar->setStub($stub);

        $phar->stopBuffering();

        // plus - compressing it into gzip  
        $phar->compressFiles(\Phar::GZ);

        # Make the file executable
        chmod(rtrim($rules['build'], '/') . "/" . $rules['phar'], 0770);
        deleteTree($buildLocation);
    }
}