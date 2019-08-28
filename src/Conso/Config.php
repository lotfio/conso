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
    public static function addCommands(string $arrayFile) : array
    {
        // avoid directory separator problems in multiple platforms
        $arr = str_replace('/', DIRECTORY_SEPARATOR, $arrayFile);
        $arr = str_replace('\\', DIRECTORY_SEPARATOR, $arr);

        if (!is_dir($arr)) {
            throw new NotFoundException("wrong commands dir !");
        }

        self::$configArray['COMMANDS'][] = $arr;

        return self::$configArray;
    }

    /**
     * Undocumented function
     *
     * @param  string $namespace
     * @return void
     */
    public static function addNamespace(string $namespace) : void
    {
        self::$configArray['NAMESPACE'][] = $namespace;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return string
     */
    public static function appName(string $name = "Conso") : string
    {
        return self::$configArray['APP_NAME'] = $name;
    }

    /**
     * Undocumented function
     *
     * @param string $version
     * @return string
     */
    public static function appVersion(string $version = "0.1.0") : string
    {
        return self::$configArray['APP_VERSION'] = $version;
    }

    /**
     * Undocumented function
     *
     * @param string $release
     * @return string
     */
    public static function appRelease(string $release = "5-18-2019 by lotfio lakehal") : string
    {
        return self::$configArray['APP_RELEASE_DATE'] = $release;
    }

    /**
     * Undocumented function
     *
     * @param string $logo
     * @return string
     */
    public static function appLogo(string $logo = NULL) : string
    {
        $file = __DIR__ . '/Commands/stub/logo';

        return self::$configArray['APP_LOGO_FILE'] = is_null($logo) ? $file : $logo;
    }

    /**
     * Undocumented function
     *
     * @param string $command
     * @return void
     */
    public static function appDefaultCommand(string $command = "Info")
    {
        return self::$configArray['DEFAULT_COMMAND'] = $command;
    }

    /**
     * load default configuration file.
     *
     * @return void
     */
    public static function load() : void
    {
        $appConf = (array) require __DIR__.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'app.php'; // app config
        self::$configArray = array_merge(self::$configArray, $appConf);
    }

    /**
     * get configuration rule.
     *
     * @param string $key
     *
     * @return string
     */
    public static function get(string $key)
    {
        if (!array_key_exists($key, self::$configArray)) {
            throw new NotFoundException("Config key $key not found !");
        }

        return self::$configArray[$key];
    }
}
