<?php
/**
 * Loading core classes
 *
 * PHP version 5
 *
 * @category Config
 * @author   Denis Porplenko <porplenko@gmail.com
 */

$loadFiles = array(
    APP . DIRECTORY_SEPARATOR . 'A',
    COMPONENTS . DIRECTORY_SEPARATOR . 'MainApp',
    HELPERS . DIRECTORY_SEPARATOR . 'CommonHelpers',
    COMPONENTS . DIRECTORY_SEPARATOR . 'RequestManager',
    COMPONENTS . DIRECTORY_SEPARATOR . 'ResponseManager',
    COMPONENTS . DIRECTORY_SEPARATOR . 'ResponseTypeFactory',
    COMPONENTS . DIRECTORY_SEPARATOR . 'MainLogger',
    COMPONENTS . DIRECTORY_SEPARATOR . 'AppException',
    VENDORS . DIRECTORY_SEPARATOR . 'MysqliDb',
    COMPONENTS . DIRECTORY_SEPARATOR . 'MainDb',
    COMPONENTS . DIRECTORY_SEPARATOR . 'MainModule',
    );

foreach ($loadFiles as $file) {
    require_once($file . '.php');
}


