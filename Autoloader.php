<?php

namespace Thirdparty;


/**
 * 执行自动加载 自动加载类
 * Class Autoloader
 * @package Thirdparty
 */
class Autoloader
{

    protected static $_autoloadRootPath = '';

    /**
     * Set autoload root path.
     *
     * @param string $root_path
     * @return void
     */
    public static function setRootPath($root_path)
    {
        self::$_autoloadRootPath = $root_path;
    }


    public static function loadByNamespace($name)
    {
        $class_path = \str_replace('\\', \DIRECTORY_SEPARATOR, $name);
        if (\strpos($name, 'Thirdparty\\') === 0) {
            $class_file = __DIR__ . \substr($class_path, \strlen('Thirdparty')) . '.php';
        } else {
            if (self::$_autoloadRootPath) {
                $class_file = self::$_autoloadRootPath . \DIRECTORY_SEPARATOR . $class_path . '.php';
            }
            if (empty($class_file) || !\is_file($class_file)) {
                $class_file = __DIR__ . \DIRECTORY_SEPARATOR . '..' . \DIRECTORY_SEPARATOR . "$class_path.php";
            }
        }

        if (\is_file($class_file)) {
            require_once($class_file);
            if (\class_exists($name, false)) {
                return true;
            }
        }
        return false;
    }
}

\spl_autoload_register('\Thirdparty\Autoloader::loadByNamespace');