<?php

namespace Conso;

/**
 * @author    <contact@lotfio.net>
 *
 * @version   1.0.0
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

    if (is_string($command['action']) && class_exists($command['action'])) { // if is controller
        foreach ($list as $lst) {
            if (empty($command[$lst])) {
                $command[$lst] = readProtectedProperty($command['action'], $lst);
            }
        }
    } // fill from command class if not defined by method
}
