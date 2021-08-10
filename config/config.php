<?php

ob_start();
session_start();
date_default_timezone_set('Asia/Kathmandu');

define('SITE_URL','http://sms730.loc');
define('SITE_NAME','School Management System,for any schools');

define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PWD','');
define('DB_NAME','php_sms_730');

define('CLASS_PATH',$_SERVER['DOCUMENT_ROOT'].'/class');

define('ERROR_LOG',$_SERVER['DOCUMENT_ROOT'].'/error/error.log');

define("ASSETS_URL", SITE_URL."/assets");
define("CSS_URL", ASSETS_URL."/css");
define ("JS_URL", ASSETS_URL."/js");
define ("IMAGES_URL",ASSETS_URL."/img");