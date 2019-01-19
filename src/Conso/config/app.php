<?php

defined('DS')               || define('DS', DIRECTORY_SEPARATOR);
defined('APP_NAME')         || define('APP_NAME', 'Conso');
defined('APP_VERSION')      || define('APP_VERSION', '0.1.0');
defined('APP_RELEASE_DATE') || define('APP_RELEASE_DATE', date("D M j G:i:s T Y"));

defined("DEFAULT_COMMAND")  || define("DEFAULT_COMMAND", 'Info');

// dirs
defined('COMMANDS')         || define('COMMANDS', dirname(__DIR__) . DS . 'Commands' . DS);


if(!function_exists('out'))
{
    function out($output)
    {
        return fwrite(STDOUT, $output);
    }
}