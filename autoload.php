<?php

/**
 * @author    Lotfio Lakehal <contact@lotfio.net>
 *
 * @version   0.1.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */
class Autoloader
{
    /**
     * base directory name.
     *
     * @var string
     */
    private $dir = __DIR__.DIRECTORY_SEPARATOR;

    /**
     * package source folder.
     *
     * @var string
     */
    private $src = 'src'.DIRECTORY_SEPARATOR;

    /**
     * load from directory method
     * load all files from withing a specefic dir.
     *
     * @param string $dirName
     *
     * @return void
     */
    public function loadFromDir($dirName)
    {
        $dir = $this->dir.$this->src.rtrim($dirName, '/').DIRECTORY_SEPARATOR;
        $files = $dir.'*.php';

        foreach (glob($files) as $file) {
            if (!file_exists($file)) {
                exit("\n\e[1;37;41m Error unable to load file $file file not found ! \e[0m\n\n");
            }
            require_once $file;
        }
    }

    /**
     * load classes on call.
     *
     * @param string $class
     *
     * @return void
     */
    public function loadClasses($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, ucfirst(trim($class)));
        $file = $this->dir.$this->src.$class.'.php';

        if (file_exists($file)) {
            require_once $file;
        }
    }

    /**
     * load classes and files method.
     *
     * @return void
     */
    public function load()
    {
        $this->loadFromDir('Conso/config/');

        return spl_autoload_register([$this, 'loadClasses']);
    }
}

(new Autoloader())->load();
