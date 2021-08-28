<?php
//In this script recieve forgotpassword's email address from the form and validate that email

require_once '../config/init.php';
$user = new User; //email adress is present in db or not verify first

if(isset($_POST) && !empty($_POST)){
    $user_email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    if(!user_email){
        redirect("../forgotpassword.php","error","Invalid Email Format.");
    }

    $user_info = $user->getUserByEmail($user_email);
    if(!$user_info){
        redirect("../forgotpassword.php","error","Email not registered.");
    }

    $token = generateRandomString(100);
    $data = array(
        'forget_token' => $token
    );
    $status = $user->updateById($data,$user_info[0]->id);
    //Send Email to Registered User
    sendEmail();

}else{
    redirect("../forgotpassword.php","error","Please provide your username");
}
?>