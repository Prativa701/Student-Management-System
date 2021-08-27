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
?>