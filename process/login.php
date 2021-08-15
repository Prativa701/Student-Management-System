<?php
    require_once "../config/init.php";
    $user = new User;
    if(isset($_POST) && !empty($_POST)){
       $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
       if(!$email){ //if email is not in email format
           redirect("../","error","Inavlid email format");
       }
       //validate email with users

       $user_info = $user->getUserByEmail($email); //this function executes 'Select * from users where email=$email' 
       debug($user_info);
    
    }else{
        redirect("../","warning","Please Login First");
    }
   

