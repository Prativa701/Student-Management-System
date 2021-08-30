<?php
//verify password and confirm password
require_once "../config/init.php";
$user = new User;

//debug($_SESSION);
//debug($_POST);

if(isset($_POST['password'], $_POST['re_password']) && !empty($_POST['password']) && !empty($_POST['re_password'])){
    $password = $_POST['password'];
    $re_password = $_POST['re-password'];

    if($password != $re_password){
        redirect("../reset-password.php?token=".getSession('forget_token'));
    }

    $password_hash = password_hash($_POST['password'],PASSWORD_BCRYPT);
    $user_data = array(
        'password' => $password_hash,
        'forget_token' => ""
    );
    $update_status =  $user->UpdateById($user_data, getSession('reset_user'));
    if($update_status){
        unset($_SESSION['reset_user']);
        unset($_SESSION['forget_token']);
        redirect("./","success","Your password changed successfully,please login with new password.");
    }else{
        redirect("../reset-password.php?token=".getSession('forget_token'),"error","Sorry your password could not be changed at the moment,please contact Administration.");
    }
}else{
    redirect("../","error","Unauthorized Access.");
}