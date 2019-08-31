<?php

/**
 * @author    <contact@lotfio.net>
 * @version   0.2.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */
return array(

    'APP_NAME'          => "Conso",
    'APP_VERSION'       => '0.2.0',
    'APP_RELEASE_DATE'  => '30/08/2019 20:00 by lotfio lakehal',

    'DEFAULT_COMMAND' => 'Info',

    'APP_LOGO_FILE'   => dirname(__DIR__). '/Commands/stub/logo',
    
     'COMMANDS'          => array(
        dirname(__DIR__).'/Commands/'
    ),

    'NAMESPACE' => array(
        "Conso\\Commands\\"
    )
);