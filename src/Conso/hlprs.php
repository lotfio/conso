<?php

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.9.0
 *
 * @license   MIT
 *
 * @category  CLI
 *
 * @copyright 2019 Lotfio Lakehal
 */

/**
 * flatten array method (multi-dimensional to single).
 *
 * @param array $arr
 *
 * @return void
 */
function flatten(array $arr): array
{
    $singleDimArray = [];

    foreach ($arr as $item) {
        if (is_array($item)) {
            $singleDimArray = array_merge($singleDimArray, flatten($item));
        } else {
            $singleDimArray[] = $item;
        }
    }

    return $singleDimArray;
}

/**
 * get private and protected properties.
 *
 * @param string $class
 * @param string $pr
 *
 * @return ?array
 */
function readProtectedProperty(string $class, string $property)
{
    $cmd = new \ReflectionClass($class);

    if ($cmd->hasProperty($property)) { // return property if exists
        $property = $cmd->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($cmd->newInstanceWithoutConstructor());
    }

    return [];
}

/**
 * read command properties from class.
 *
 * @param array $command
 *
 * @return void
 */
function readCommandPropertiesFromClass(array &$command): void
{
    $list = ['sub', 'flags', 'description', 'help', 'aliases'];

    if (is_string($command['action'])) { // if is controller

        $namespace = (!is_null($command['namespace'])) ? rtrim($command['namespace'], '\\').'\\' : '';
        $class = $namespace.ucfirst($command['action']);

        if (class_exists($class)) {
            foreach ($list as $lst) {
                if (empty($command[$lst])) {
                    $command[$lst] = readProtectedProperty($class, $lst);
                }
            }
        }
    } // fill from command class if not defined by method
}

/**
 * display command help helper function.
 *
 * @param array $command
 *
 * @return void
 */
function commandHelp(array $command, $output)
{
    $name = $command['name'];
    $help = $command['help'];

    $output->writeLn("\n help for [".$name."] command:\n\n", 'yellow');
    $output->writeLn("   php conso $name:[sub command] [options] [flags]\n");

    if (is_array($help) && count($help) > 0) {
        foreach ($help as $key => $value) {
            $output->writeLn("\n ".$key.":\n\n", 'yellow');

            // get longest
            $max = 0;
            if (count($value) > 0) {
                $max = array_map(function ($elem) { return strlen($elem); }, array_keys($value));
                $max = max($max);
            }

            foreach ($value as $a => $b) {
                $key = !is_numeric($a) ? $a.str_repeat(' ', ($max - (strlen($a)))).'  : ' : null;
                $output->writeLn('   '.$key.$b."\n");
            }
        }
    }
}

/**
 * copy directory recursively
 *
 * @param string $source
 * @param string $destination
 * @return void
 */
function copyDirectory(string $source, string $destination) : void
{
    mkdir($destination, 0755, true);

    foreach (
    $iterator = new \RecursiveIteratorIterator(
        new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
        \RecursiveIteratorIterator::SELF_FIRST) as $item
    )
    {
        if ($item->isDir()) {
            mkdir($destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        } else {
            copy($item, $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
        }
    }
}

/**
 * delete directory recursively
 *
 * @param string $dir
 * @return void
 */
function deleteTree(string $dir)
{ 
    if(!is_dir($dir))
        return false;
        
    $files = array_diff(scandir($dir), array('.', '..')); 

    foreach ($files as $file) { 
        (is_dir("$dir/$file")) ? deleteTree("$dir/$file") : unlink("$dir/$file"); 
    }

    return rmdir($dir); 
} 