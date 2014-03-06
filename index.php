<?php

define('APP', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'app' );
define('COMPONENTS', APP . DIRECTORY_SEPARATOR .'components' );
define('MODULES', APP . DIRECTORY_SEPARATOR . 'modules' );
define('VENDORS', APP . DIRECTORY_SEPARATOR . 'vendors' );
define('CONFIG', APP . DIRECTORY_SEPARATOR . 'config' );
define('HELPERS', APP . DIRECTORY_SEPARATOR . 'helpers' );

$preload    = APP . DIRECTORY_SEPARATOR . 'preload.php';
require_once($preload);

A::createApp()->go();
