<?php


//for php
date_default_timezone_set('Asia/Ho_Chi_Minh');
//display all possible errors
ini_set('display_errors', 1);
error_reporting(E_ALL);

//for database
SystemConfig::addRange(array(
    'DB_TYPE' => 'mysql',
    'HOST_NAME' => '127.0.0.1',
    'USER_NAME' => 'root',
    'DB_NAME' => 'myday',
    'PASSWORD' => ''
));

//for framework
SystemConfig::add('SUPPORTED_HTTP_METHOD', ['GET', 'POST']);
SystemConfig::add('ROUTE_FOLDER_LIST', ['auth', 'myday']);

SystemConfig::add('MODULE_FOLDER', 'module/');
SystemConfig::add('ROUTE_FOLDER', 'route/');
SystemConfig::add('MIDDLEWARE_FOLDER', 'middleware/');
SystemConfig::add('MODEL_FOLDER', 'model/');
SystemConfig::add('CONTROLLER_FOLDER', 'controller/');
SystemConfig::add('VIEW_FOLDER', 'view/');
SystemConfig::add('DIRECTION_EXTENSION', '../');

SystemConfig::add('METHOD_CHAR', '@');
SystemConfig::add('OPTION_CHAR', '#');

