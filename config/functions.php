<?php

function debug($data, $is_exit = false){
    echo "<pre style ='background: #FFFFFF'>";
    print_r($data);
    echo "</pre>";
    if($is_exit){
        exit;
    }
}

//when only we want to set msg
function setSession($key,$value){ // function runs only if session is started else..
    if(!isset($_SESSION)){
        session_start();
    }
    $_SESSION[$key] = $value;
}

//to get the value of key  
function getSession($key = null){
    if($key!= null && isset($_SESSION[$key])){
        return $_SESSION[$key];
    }else{
        return $_SESSION;  //else if key is not set in session, return whole session
    }
}

function redirect($path,$session_key= null,$session_msg= null){ //setting null so we can only set key n msg without value
    if($session_key!= null && $session_msg!= null){ //when in case not null, following code runs in that way
        setSession($session_key,$session_msg);
    }
        header("location: ".$path);
        exit;
}

function flash(){
    if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
        echo "<p class = 'alert alert-success'>".getSession('success')."</p>";
        unset($_SESSION['success']);
    }

    if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
        echo "<p class = 'alert alert-danger'>".getSession('error')."</p>";
        unset($_SESSION['error']);
    }

    if(isset($_SESSION['warning']) && !empty($_SESSION['warning'])){
        echo "<p class = 'alert alert-warning'>".getSession('warning')."</p>";
        unset($_SESSION['warning']);
    }
}

function generateRandomString($length = 100){
    $chars ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $str_length = strlen($chars);
    $random = "";
    for($i=0; $i<=$length; $i++){
        $random_posn = rand(0,$str_length-1); //0,61 i.e min & max
        $char =  $chars[$random_posn];
        $random .= $char;
    }
    return $random;
}

function sanitize($str){      //returns plain text
   // $str = strip_tags($str); //<p>pratee</p> in asdf => pratee
   // $str = rtrim($str);      //rtrim() removes spaces from string
   // return $str;
      return htmlentities(rtrim(strip_tags($str)));
}

function sendemail($to){

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = SMTP_HOST;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = SMTP_USER;                     //SMTP username
        $mail->Password   = SMTP_KEY;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');
    
        //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    //debug($mail,true);
}
?>