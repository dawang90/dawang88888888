<?php


    // change the following paths if necessary
    header('Content-Type:text/html;charset=utf-8');
    define('APP_ROOT', dirname(dirname(__FILE__)));
    define('WEB_ROOT', dirname(__FILE__));
    define('BEGIN_MEM_SIZE', memory_get_usage());
    $yii = 'framework/yii.php';
    $enabledDebug = true;
    $evi = filter_input(INPUT_SERVER, 'ENVIRONMENT');

    error_reporting(E_ALL & ~E_NOTICE);
    $config = APP_ROOT . '/config/devel.php';

    require_once($yii);
    $app = Yii::createWebApplication($config);
    $app->run();
