<?php
    require_once 'config/init.php';
    require_once 'inc/checklogin.php';

    //destroy token from database column remember_token
    $user = new User;

    if(isset($_COOKIE['_au'])){
        $data = array(
            'remember_token' => ''           //setting the value of token null that has remained in database
        );
        $user->updateById($data, getSession('user_id')); //then update the data of keeping token value null
        setcookie("_au","",time()-60,"/");  //destroy cookie to logout
    }

    session_destroy();                      //destroy session to logout
    redirect("./","success","Thank you for using sms730");

?>