<?php
header('Content-Type: text/html; charset=UTF-8');
use PhSpring\Engine\Config;
use Doctrine\Common\Annotations\AnnotationRegistry;

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

if(!file_exists(APPLICATION_PATH.'/tmp')){
    mkdir(APPLICATION_PATH.'/tmp');
}
if(!file_exists(APPLICATION_PATH.'/tmp/AnnotationCache')){
    mkdir(APPLICATION_PATH.'/tmp/AnnotationCache');
}

$loader = require_once APPLICATION_PATH . '/../vendor/autoload.php';


AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace(array('DF'));

Config::init();

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
        APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
        ->run();
