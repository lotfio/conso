<?php

/**
 * @author    <contact@lotfio.net>
 *
 * @version   0.1.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */
return [

    //TODO:: sould set CLI version or name to disable ansi to prevent those messy charachters where no ansi support
    'OS'                => PHP_OS,

    'APP_NAME'          => 'Conso',

    'APP_VERSION'       => '0.1.0',

    'APP_RELEASE_DATE'  => ' 5-18-2019 by lotfio lakehal',

    'APP_LOGO_FILE'     => dirname(__DIR__).DIRECTORY_SEPARATOR.'Commands'.DIRECTORY_SEPARATOR.'Helpers'.DIRECTORY_SEPARATOR.'Stubs'.DIRECTORY_SEPARATOR.'logo.stub',

    'DEFAULT_COMMAND'   => 'Info',

    'DEFAULT_COMMANDS'  => dirname(__DIR__).DIRECTORY_SEPARATOR.'Commands'.DIRECTORY_SEPARATOR,

    'COMMANDS'          => dirname(__DIR__).DIRECTORY_SEPARATOR.'Commands'.DIRECTORY_SEPARATOR,

    'DEFAULT_COMMANDS_NAMESPACE' => 'Conso\\Commands\\', // this sould be moved to project config

    'COMMANDS_NAMESPACE'         => 'Conso\\Commands\\', // this sould be moved to project config
];
