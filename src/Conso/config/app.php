<?php

/**
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

defined('OS')               || define('OS', php_uname("s"));
defined('DS')               || define('DS', DIRECTORY_SEPARATOR);
defined('APP_NAME')         || define('APP_NAME', 'Conso');
defined('APP_VERSION')      || define('APP_VERSION', '0.1.0');
defined('APP_RELEASE_DATE') || define('APP_RELEASE_DATE', date('d-m-Y') . " by lotfio lakehal");

defined('DEFAULT_COMMAND')  || define('DEFAULT_COMMAND', 'Info');

// dirs
defined('COMMANDS')         || define('COMMANDS', dirname(__DIR__).DS.'Commands'.DS);


/**
 * write to output function
 */
if (!function_exists('out')) {
    function out($output)
    {
        return fwrite(STDOUT, $output);
    }
}

/**
 * get input function
 */
if (!function_exists('inp')) {
    function inp()
    {
        return new Conso\Input;
    }
}

/**
 * check if testing 
 *
 * @return boolean
 */
if (!function_exists('isTest')) {
    function isTest()
    {
        $file = explode(DIRECTORY_SEPARATOR, $_SERVER['PHP_SELF']);
        return (strpos($file[0], 'phpunit') !== FALSE) ? true : false;
    }
}