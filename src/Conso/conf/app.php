<?php

/**
 * @author    <contact@lotfio.net>
 *
 * @version   0.2.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */
return [

    'APP_NAME'          => 'Conso',
    'APP_VERSION'       => '0.2.0',
    'APP_RELEASE_DATE'  => '30/08/2019 20:00 by lotfio lakehal',

    'DEFAULT_COMMAND' => 'info',

    'APP_LOGO_FILE'   => dirname(__DIR__).'/Commands/stub/logo',

     'COMMANDS'          => [
        dirname(__DIR__).'/Commands/',
    ],

    'NAMESPACE' => [
        'Conso\\Commands\\',
    ],
];
