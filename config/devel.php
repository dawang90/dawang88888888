<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'dawang',
    // preloading 'log' component
    'preload' => array('log'),
    'id' => 'dawang',
    'import' => array(
        'application.components.*',
        'application.models.site.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'dawang'
        ),
    ),
    'defaultController' => 'Index',
    'components' => array(
        'db' => array(
            'connectionString' => 'localhost:3306',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableParamLogging' => true
        )
    ),
    'params' => array(
        'assetsUrl' => '',
    ),
);