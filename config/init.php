<?php

require_once $_SERVER['DOCUMENT_ROOT']."/config/config.php";
require_once $_SERVER['DOCUMENT_ROOT']."/config/init.php";

spl_autoload_register(function($class_name){
    require_once CLASS_PATH."/".$class_name.'.php';
});
