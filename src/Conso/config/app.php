<?php

define('DS', DIRECTORY_SEPARATOR);

if(!function_exists('out'))
{
    function out($output)
    {
        return fwrite(STDOUT, $output);
    }
}