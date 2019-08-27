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

/**
 * write to output function.
 */
if (!function_exists('out')) {
    function out($output)
    {
        return fwrite(STDOUT, $output);
    }
}

/*
 * get input function
 */
if (!function_exists('inp')) {
    function inp()
    {
        return new Conso\Input();
    }
}

/*
 * check if testing
 *
 * @return boolean
 */
if (!function_exists('isTest')) {
    function isTest()
    {
        $file = explode(DIRECTORY_SEPARATOR, $_SERVER['PHP_SELF']);

        return (strpos($file[count($file) - 1], 'phpunit') !== false) ? true : false;
    }
}

if(!function_exists('extractNamespace'))
{
    function extractNamespace($file) {
        $ns = NULL;
        $handle = fopen($file, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                if (strpos($line, 'namespace') === 0) {
                    $parts = explode(' ', $line);
                    $ns = rtrim(trim($parts[1]), ';');
                    break;
                }
            }
            fclose($handle);
        }
        return $ns;
    }
}