<?php

defined('DS')               || define('DS', DIRECTORY_SEPARATOR);
defined('APP_NAME')         || define('APP_NAME', 'Conso');
defined('APP_VERSION')      || define('APP_VERSION', '0.1.0');
defined('APP_RELEASE_DATE') || define('APP_RELEASE_DATE', date('Y-H-D'));


if(!function_exists('out'))
{
    function out($output)
    {
        return fwrite(STDOUT, $output);
    }
}