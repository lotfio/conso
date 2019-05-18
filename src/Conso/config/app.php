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
/*
defined('OS')               || define('OS', php_uname("s"));
defined('DS')               || define('DS', DIRECTORY_SEPARATOR);
defined('APP_NAME')         || define('APP_NAME', 'Conso');
defined('APP_VERSION')      || define('APP_VERSION', '0.1.0');
defined('APP_RELEASE_DATE') || define('APP_RELEASE_DATE', date('d-m-Y') . " by lotfio lakehal");

defined('DEFAULT_COMMAND')  || define('DEFAULT_COMMAND', 'Info');

// dirs
defined('COMMANDS')         || define('COMMANDS', dirname(__DIR__).DS.'Commands'.DS);
*/
return [
    
    "OS"                => php_uname("s"),
    
    "APP_NAME"          => "Conso",
    
    "APP_VERSION"       => "0.1.0",
    
    "APP_RELEASE_DATE"  => " 5-18-2019 by lotfio lakehal",

    "DEFAULT_COMMAND"   => "Info",

    "DEFAULT_COMMANDS"  => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR,
    
    "COMMANDS"          => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Commands' . DIRECTORY_SEPARATOR,

    "DEFAULT_COMMANDS_NAMESPACE" => "Conso\\Commands\\", // this sould be moved to project config

    "COMMANDS_NAMESPACE"         => "Builds\\" // this sould be moved to project config
];