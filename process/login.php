<?php
    require_once "../config/init.php";
    require_once "../config/function.php";
   
    if(isset($_POST) && !empty($_POST)){

    }else{
        $_SESSION['warning'] = "Please Login First";
        header("location: ../");
        exit;
    }
   

