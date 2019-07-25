<?php

namespace Conso;

/*
 *
 * @author    <contact@lotfio.net>
 * @package   Conso PHP Console Creator
 * @version   0.1.0
 * @license   MIT
 * @category  CLI
 * @copyright 2019 Lotfio Lakehal
 */

use Conso\Exceptions\NotFoundException;

class Config
{
    /**
     * config array.
     *
     * @var array
     */
    public static $configArray = [];

    /**
     * add configuration rules.
     *
     * @param string $arrayFile
     *
     * @return void
     */
    public static function add(string $arrayFile) : array
    {
        // avoid directory separator problems in multiple platforms
        $arr = str_replace('/', DIRECTORY_SEPARATOR, $arrayFile);
        $arr = str_replace('\\', DIRECTORY_SEPARATOR, $arr);

        if (!file_exists($arr)) {
            throw new NotFoundException("Config file $arr not found !");
        }
        $arr = (array) require_once $arr; // added config

        self::$configArray = array_merge(self::$configArray, $arr);

        return self::$configArray;
    }

    /**
     * load default configuration file.
     *
     * @return void
     */
    public static function load() : void
    {
        $appConf = (array) include_once __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php'; // app config
        self::$configArray = array_merge(self::$configArray, $appConf);
    }

    /**
     * get configuration rule.
     *
     * @param string $key
     *
     * @return string
     */
    public static function get(string $key) : string
    {
        if (!array_key_exists($key, self::$configArray)) {
            throw new NotFoundException("Config key $key not found !");
        }

        return self::$configArray[$key];
    }
}
