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