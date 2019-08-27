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

trait CommandTrait
{
    /**
     * read all commands method
     * 
     * This method reads all commands and there namespaces
     * from the COMMAND key of the config array
     * it returns an array of commands and there namespaces
     * 
     * @return array
     */
    public function readCommands()
    {
        $commands = array();

        foreach(Config::get('COMMANDS') as $dir)
        {
            $files = preg_grep('/.php$/', scandir($dir));

            foreach($files as $commandFile)
            {
                $file = trim($dir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $commandFile;

                if(file_exists($file))
                {
                    $commands[trim($commandFile, '.php')] =  trim(extractNamespace($file), "\\") . "\\";
                }

            }
        }

        return $commands;
    }
}