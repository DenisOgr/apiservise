<?php
/**
 * Singelton class to config
 *
 * PHP version 5
 *
 * @author   Denis Porplenko <porplenko@gmail.com
 */

class A
{
   /**
    * Main application
    * @var MainApp
    */
    private static $_api;

    /**
     * Private construct so nobody else can instance it
     *
     */
    private function __construct()
    {

    }

    /**
     * Get main application
     * @return MainApp Object main application
     */
    public static function getMainApp()
    {
        return self::$_api;
    }

    /**
     * Autoloader
     * @param  string  $path  Path to durectory
     * @param  string  $class Loader class name
     * @param  boolean $init  Need instance
     * @return mixed
     */
    public static function load($path, $class, $init = true)
    {
        try {
            if (!class_exists($class, false) && !interface_exists($class, false)) {

                $pathToClass = $path . '/' . $class. '.php';

                if (!is_file($pathToClass)) {
                     throw new Exception('File ' . $pathToClass . ' not found');
                }

                require_once($pathToClass);
            }
            if (class_exists($class, false) || interface_exists($class, false)) {
                return ($init) ? new $class : true;
            } else {
                throw new Exception('Class ' . $class . ' not found');
            }
        } catch (Exception $e) {
            print_r('<pre>');
            print_r($e);
            print_r('</pre>');
            exit();
        }

    }

    /**
     * Set main application
     * @param MainApp $app Amin application
     */
    public static function setApp($app)
    {
        if(self::$_api === null || $app === null)
            self::$_api = $app;
        else
            throw new Exception('App application can only be created once.');
    }

    /**
     * Create new Application
     * @return MainApp $app Amin application
     */
    public static function createApp()
    {
        if (self::$_api === null) {
            require_once(COMPONENTS . DIRECTORY_SEPARATOR . 'MainApp.php' );
            $config     = require_once(CONFIG . '/main.php');
            return  new MainApp($config);
        }
        return  self::$_api;
    }
}
