<?php
function debug($data, $is_exit = false){
    echo "<pre style ='background: #FFFFFF'>";
    print_r($data);
    echo "</pre>";
    if($is_exit){
        exit;
    }
}

function redirect($path,$session_key= null,$session_msg= null){
    if($session_key!= null && $session_msg!= null){
        $_SESSION[$session_key] = $session_msg;
    }
        header("location: ".$path);
        exit;
}
?>