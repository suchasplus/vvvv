<?php

error_reporting(E_ALL);
define( 'DS' , DIRECTORY_SEPARATOR );
define( 'VROOT' , realpath(dirname( __FILE__ )) . DS );

require_once VROOT . 'classes' . DS . 'config.php';

date_default_timezone_set ( Config::get('system', 'timezone') );




//Config::get('weibo','appkey');
//
//$ret = Config::getWeibo('name','default');
//var_dump($ret);
//die();



