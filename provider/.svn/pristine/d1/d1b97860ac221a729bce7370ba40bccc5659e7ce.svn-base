<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(true);//开启错误报告
//error_reporting(8191);

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return $usec + $sec;
}


$start_t = microtime_float();

date_default_timezone_set('Asia/Shanghai');//配置地区
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../libs'),
	realpath(APPLICATION_PATH . '/models'),
	realpath(APPLICATION_PATH . '/modules'),
	APPLICATION_PATH,
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/server.ini'
);

$application->bootstrap();

//$application->getBootstrap()->getResource("frontController")->setParam('useDefaultControllerAlways', true);
$application->run();

